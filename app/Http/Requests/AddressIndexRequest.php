<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressIndexRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'sometimes|nullable',
            'paginate' => 'sometimes|nullable|boolean',
            'page_size' => 'sometimes|nullable|int',
            'type' => 'sometimes|nullable|in:billing,shipping',
        ];
    }
}
