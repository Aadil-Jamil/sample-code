<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\PageRequest;
use App\Http\Resources\Vendor\PageResource;
use App\Http\Requests\Vendor\PageIndexRequest;
use App\Models\Page;
use App\Repository\Contracts\PageRepositoryInterface;
use Exception;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Page
 * @authenticated
 * APIs for Vendor Pages.
 */

class PagesController extends Controller
{
    protected $user;
    private $repo;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->user = auth()->user();
        $this->repo = $repository;
    }

    /**
     * Get all pages Admin|Vendor
     * @queryParam shop_id string required The shop_id is required when get pages for admin side.
     * @apiResource App\Http\Resources\Vendor\PageResource
     * @apiResourceModel App\Models\Page
     *
     * @return ResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index(PageIndexRequest $request)
    {
        $data = $request->validated();
        try {
            $page = $this->repo->getAllPages($data);
            return successResponse($page, config('messages.fetch_pages'), $data['paginate'] ?? FALSE);
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Vendor Show page Admin|Vendor
     *
     * @apiResource App\Http\Resources\Vendor\PageResource
     * @apiResourceModel App\Models\Page
     *
     * @return PageResource|\Illuminate\Http\JsonResponse
     */
    public function show(Page $page, $id)
    {
        try {
            $page = $this->repo->showPageDetail($id);
            return successResponse($page, config('messages.fetch_page_data'));
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Update page Admin|Vendor
     *
     * @apiResource App\Http\Resources\Vendor\PageResource
     * @apiResourceModel App\Models\Page
     *
     * @return PageResource|\Illuminate\Http\JsonResponse
     */
    public function update(PageRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $page = $this->repo->updatePage($id, $data);
            return successResponse($page, config('messages.update_page'));
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    /**
     * Get page by slug
     *
     * @apiResource App\Http\Resources\Vendor\PageResource
     * @apiResourceModel App\Models\Page
     *
     * @return PageResource|\Illuminate\Http\JsonResponse
     */
    public function getPageBySlug($slug)
    {
        try {
            $page = $this->repo->showPageBySlug($slug);
            return successResponse($page, config('messages.fetch_page_data'));
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
