<?php

namespace App\Repository\Contracts;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Vendor\PageResource;

interface PageRepositoryInterface extends EloquentRepositoryInterface
{

    /**
     * Summary of getAllPages
     * @param array $data
     * @return mixed
     */
    public function getAllPages(array $data);
    /**
     * Summary of showPageDetail
     * @param int $id
     * @return PageResource|Page
     */
    public function showPageDetail(int $id) : PageResource|Page;
    /**
     * Summary of showPageDetail
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updatePage(int $id, array $data) : bool;
     /**
     * Summary of showPageBySlug
     * @param string $slug
     * @return PageResource
     */
    public function showPageBySlug(string $slug) : PageResource;

}