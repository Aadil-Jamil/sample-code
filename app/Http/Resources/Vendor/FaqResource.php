<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'details' => $this->details,
            'sorting' => $this->sorting,
        ];

        if (auth()->user()?->hasRole('admin'))
            $arr['shop_id'] = $this->shop_id;

        return $arr;
    }
}
