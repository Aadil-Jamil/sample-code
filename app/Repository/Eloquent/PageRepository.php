<?php
namespace App\Repository\Eloquent;

use App\Helpers\UploadHelper;
use App\Http\Resources\Vendor\PageResource;
use App\Models\Page;
use App\Repository\Contracts\PageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{

    /**
     * PageRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Page $model)
    {
        $this->model = $model;
        $this->resource = PageResource::class;
    }

    /**
     * Get all pages.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getAllPages(array $data)
    {
        $input = $this->parseSearchParameters($data);

        $page = $this->model->with('shop');

        if ($this->userHasRole('vendor')) {
            $page = $this->currentUser()->shop->pages();
        }
        if ($this->userHasRole('admin')) {
            $page = $page->where('shop_id', $data['shop_id']);
        }

        if ($input['searchText'] != "") {
            $page = $page->where(function ($q) use ($input) {
                $q->where('title', 'like', "%{$input['searchText']}%")
                    ->orWhere('details', 'like', "%{$input['searchText']}%");
            });
        }

        if ($input['sortBy'] && $input['orderBy'])
            $page = $page->orderBy($input['sortBy'], $input['orderBy']);

        return $input['paginate'] ? $this->resource::collection($page->paginate($input['pageSize'])) : $this->resource::collection($page->get());
    }

    /**
     * Show page detail.
     * @param int $id
     *
     * @return PageResource|Page
     */
    public function showPageDetail(int $id) : PageResource|Page
    {
        if ($this->userHasRole('vendor'))
            $page = $this->currentUser()->shop->pages()->where('id', $id)->firstOrFail();

        if ($this->userHasRole('admin'))
            $page = $this->findById($id, ['*'], ['shop']);

        return $this->resource::make($page);
    }

    /**
     * Update page.
     *
     * @param int $id
     * @param array $data
     *
     * @return bool
     */
    public function updatePage(int $id, array $data) : bool
    {
        if ($this->userHasRole('vendor'))
            $page = $this->currentUser()->shop->pages()->where('id', $id)->first();

        if ($this->userHasRole('admin'))
            $page = $this->findById($id);

        if (isset($data['image'])) {
            $file = $data['image'];
            $data['image'] = UploadHelper::uploadFileToS3($file, 'images/page');
            UploadHelper::deleteS3File($page->image);
        }
        
        return  $this->update($id, $data);
    }

    /**
     * Show page by slug.
     * @param string $slug
     *
     * @return PageResource
     */
    public function showPageBySlug(string $slug) : PageResource
    {
        $vendor = cache()->get('vendor');
        $segments = request()->segments();
        $page = $vendor->shop->pages()->with('shop')->where('slug', $segments[4])->firstOrFail();

        return $this->resource::make($page);
    }
}