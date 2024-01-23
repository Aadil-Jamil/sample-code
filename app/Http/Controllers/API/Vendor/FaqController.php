<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\FaqRequest;
use App\Http\Requests\Vendor\FaqIndexRequest;
use App\Http\Resources\Vendor\FaqResource;
use App\Repository\Contracts\FaqRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Faqs
 * @authenticated
 * APIs for Faqs.
 */

class FaqController extends Controller
{
    private $repo;

    public function __construct(FaqRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    /**
     * Get All Faqs
     * Get all Faqs Admin|Vendor|User
     * @apiResourceCollection App\Http\Resources\Vendor\FaqResource
     * @apiResourceModel App\Models\Faq
     *
     * @return ResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index(FaqIndexRequest $request)
    {
        $data = $request->validated();
        try {
            $faq = $this->repo->getAllfaqs($data);
            return successResponse($faq, config('messages.fetch_faqs'), $data['paginate'] ?? FALSE);
        } catch (\Exception $e) {
            return errorResponse($e);
        }
    }

    /**
     * Store Faqs
     * Store Faqs Admin|Vendor
     * @apiResourceCollection App\Http\Resources\Vendor\FaqResource
     * @apiResourceModel App\Models\Faq
     *
     * @return FaqResource|\Illuminate\Http\JsonResponse
     */
    public function store(FaqRequest $request)
    {
        $data = $request->validated();
        try {
            $faq = $this->repo->createFaq($data);
            return successResponse($faq, config('messages.create_faq'));
        } catch (\Exception $e) {
            return errorResponse($e);
        }
    }

    /**
     * Show Faqs
     *
     * Show Faqs Admin|Vendor
     *
     * @apiResourceCollection App\Http\Resources\Vendor\FaqResource
     * @apiResourceModel App\Models\Faq
     *
     * @return FaqResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $faq = $this->repo->getFaqById($id);
            return successResponse($faq, config('messages.fetch_faqs'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Update Faqs
     *
     * Update Faqs Admin|Vendor
     *
     * @apiResourceCollection App\Http\Resources\Vendor\FaqResource
     * @apiResourceModel App\Models\Faq
     *
     * @return FaqResource|\Illuminate\Http\JsonResponse
     */
    public function update(FaqRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $faq = $this->repo->updateFaq($id, $data);
            return successResponse($faq, config('messages.update_faq'));
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
                return errorResponse(config('messages.no_record'), 404);
            return errorResponse($e->getMessage(), $e->getCode());
        }

    }

    /**
     * Delete Faqs
     *
     * Delete Faqs Admin|Vendor
     *
     * @apiResourceCollection App\Http\Resources\Vendor\FaqResource
     * @apiResourceModel App\Models\Faq
     *
     * @return FaqResource|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $faq = $this->repo->deleteFaq($id);
            return successResponse($faq, config('messages.delete_faq'));
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
                return errorResponse(config('messages.no_record'), 404);
            return errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
