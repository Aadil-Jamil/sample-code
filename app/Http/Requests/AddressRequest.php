<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'address_type' => 'required|in:shipping,billing|max:10',
            'full_name' => 'required|max:50',
            'session_id' => 'sometimes|max:191',
            'address_line1' => 'required|max:65535',
            'address_line2' => 'sometimes|max:65535',
            'phone' => 'sometimes|max:50',
            'postal_code' => 'required|max:7',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'country' => 'required|in:Canada,United States|max:50',
            'default_address' => 'required|boolean',
        ];
    }
}
