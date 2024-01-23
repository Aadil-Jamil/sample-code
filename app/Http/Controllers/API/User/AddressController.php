<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressIndexRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Repository\Contracts\AddressRepositoryContract;
use DB;
use Exception;

/**
 * @group Address
 * APIs for managing Address.
 */

class AddressController extends Controller
{
    protected $user;
    private $repo;

    public function __construct(AddressRepositoryContract $repository)
    {
        $this->user = auth()->user();
        $this->repo = $repository;
    }

    /**
     * Get Address
     * @bodyParam session_id string required The session_id is required.
     * @apiResourceCollection App\Http\Resources\AddressResource
     * @apiResourceModel App\Models\Address
     *
     * @return AddressResource|\Illuminate\Http\JsonResponse
     */
    public function index(AddressIndexRequest $request)
    {
        $input = $request->validated();
        $response = $this->repo->getAddresses($input);
        return successResponse($response, config('messages.fetch_addresses'), $input['paginate'] ?? FALSE);

    }

    /**
     * Address
     * @apiResourceCollection App\Http\Resources\AddressResource
     * @apiResourceModel App\Models\Address
     *
     * @return AddressResource|\Illuminate\Http\JsonResponse
     */
    public function store(AddressRequest $request)
    {
        $validated = $request->validated();
        $addressResourceData = null;
        try {
            DB::transaction(function () use (&$addressResourceData, $validated) {
                $addressResourceData = $this->repo->addAddress($validated);
            });
            return successResponse($addressResourceData, config('messages.create_address'));
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Delete Address
     * @apiResourceCollection App\Http\Resources\AddressResource
     * @apiResourceModel App\Models\Address
     *
     * @return AddressResource|\Illuminate\Http\JsonResponse
     */
    public function destroy($user, $id)
    {
        try {
            $address = $this->repo->deleteAddress($id);
            return successResponse($address, config('messages.delete_address'));
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
