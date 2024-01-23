<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'address_type' => $this->address_type,
            'full_name' => $this->full_name,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'default_address' => $this->default_address,
        ];
    }
}
