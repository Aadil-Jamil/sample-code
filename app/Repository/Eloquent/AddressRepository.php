<?php
namespace App\Repository\Eloquent;

use App\Models\{Address, Cart};
use App\Repository\Contracts\AddressRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\AddressResource;
use App\Http\Traits\AvataxTrait;

class AddressRepository extends BaseRepository implements AddressRepositoryContract
{
    use AvataxTrait;

    protected $cartModel;

    /**
     * AddressRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Address $model, Cart $cartModel)
    {
        $this->model = $model;
        $this->cartModel = $cartModel;
        $this->resource = AddressResource::class;
    }

    /**
     * Get addresses.
     * @param array $input
     *
     * @return mixed
     */
    public function getAddresses(array $data)
    {
        $input = $this->parseSearchParameters($data);
        $input['type'] = $data['type'] ?? '';

        $address = $this->model->whereUserId($this->currentUser()->id)
            ->when($input['searchText'], function ($query) use ($input) {
                return $query->where(function ($q) use ($input) {
                    $q->where('full_name', 'like', "%{$input['searchText']}%");
                });
            })
            ->when($input['type'], function ($query) use ($input) {
                return $query->where(function ($q) use ($input) {
                    $q->where('address_type', $input['type']);
                });
            });

        return $input['paginate'] ? $this->resource::collection($address->paginate($input['pageSize'])) : $this->resource::collection($address->get());
    }

    /**
     * Add address.
     * @param array $data
     *
     * @return AddressResource
     */
    public function addAddress(array $data): AddressResource
    {
        $address = $this->model;

        if ($data['default_address']) {
            $this->model->whereUserId($this->currentUser()->id)->whereAddressType($data['address_type'])->
                whereDefaultAddress(1)->update(['default_address' => 0]);
        }

        $userAddress = [
            'state' => $data['state'],
            'zip' => $data['postal_code'],
            'country' => $data['country']
        ];

        //Validate for only tax purpose by zip code mainly.
        if ($userAddress) {
            $tax = $this->simpleTransaction($userAddress);
            if (is_string($tax)) {
                throw new Exception(json_decode($tax, true)['error']['message']);
            }
        }

        $data['user_id'] = $this->currentUser()->id;
        $address->fill($data);
        $address->save();

        return $this->resource::make($address);
    }

    /**
     * Delete address.
     * @param int $id
     *
     * @return bool
     */
    public function deleteAddress($id): bool
    {
        return $this->deleteById($id);
    }
}
