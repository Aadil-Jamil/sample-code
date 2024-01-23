<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arr = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'details' => $this->details,
            'image' => $this->image,
            'status' => $this->status,
        ];

        if (auth()->user()?->hasRole('admin') || getUserType() === 'user') {
            $arr['shop_id'] = $this->shop_id;
            $arr['shop'] = $this->whenLoaded('shop', function () {
                return ShopResource::make($this->shop);
            });
        }

        return $arr;
    }
}