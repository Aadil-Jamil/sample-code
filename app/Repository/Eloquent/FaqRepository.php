<?php
namespace App\Repository\Eloquent;

use App\Http\Resources\Vendor\FaqResource;
use App\Models\Faq;
use App\Repository\Contracts\FaqRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    /**
     * FaqRepository constructor.
     *
     * @param Model $model
     * @return void
     */
    public function __construct(Faq $model)
    {
        $this->model = $model;
        $this->resource = FaqResource::class;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getAllFaqs(array $data)
    {
        $input = $this->parseSearchParameters($data);
        $input['shopId'] = $data['shop_id'] ?? null;

        $faq = $this->model;

        if ($this->userHasRole('vendor'))
            $faq = $this->currentUser()->shop->faqs();

        // Not auth user so access directly
        if (getUserType() == 'user') {
            $vendor = Cache::get('vendor');
            $faq = $faq->where('shop_id', $vendor->shop->id);
        }

        if ($input['shopId'])
            $faq = $faq->where('shop_id', $input['shopId']);


        if ($input['searchText'] != "") {
            $faq = $faq->where(function ($q) use ($input) {
                $q->where('title', 'like', "%{$input['searchText']}%")
                    ->orWhere('details', 'like', "%{$input['searchText']}%");
            });
        }

        $faq = $faq->sorted();

        return $input['paginate'] ? $this->resource::collection($faq->paginate($input['pageSize'])) : $this->resource::collection($faq->get());
    }

    /**
     * @param array $data
     * @return FaqResource
     */
    public function createFaq(array $data) : FaqResource
    {
        if ($this->userHasRole('vendor'))
            $faq = $this->currentUser()->shop->faqs()->create($data);

        if ($this->userHasRole('admin'))
            $faq = $this->create($data);

        return $this->resource::make($faq);
    }

    /**
     * @param int $id
     * @return FaqResource
     */
    Public function getFaqById(int $id) : FaqResource
    {
        $faq = $this->findById($id);
        return $this->resource::make($faq);
    }

    /**
     * Summary of updateFaq
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateFaq(int $id, array $data) : bool
    {
        $faq = $this->update($id, $data);
        return $faq;
    }

    /**
     * Summary of deleteFaq
     * @param int $id
     * @return bool
     */
    public function deleteFaq(int $id) : bool
    {
        if ($this->userHasRole('admin') || $this->userHasRole('vendor'))
            $faq = $this->deleteById($id);

        return $faq;
    }

}
