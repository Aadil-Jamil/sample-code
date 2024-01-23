<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 * @bodyParam title string required The title is required.
 * @bodyParam details string optional The details is optional.
 *
 */


class PageRequest extends FormRequest
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
        return [] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store()
    {
        return [
            'shop_id' => 'required|exists:shops,id',
            'title' => 'required|sometimes|max:255',
            'details' => 'required|max:65535',
            'image' => 'sometimes|nullable|image|max:65535',
        ];
    }

    protected function update()
    {
        return [
            'details' => 'sometimes|nullable|max:65535',
            'image' => 'sometimes|nullable|image|max:65535',
            'status' => 'sometimes|nullable|int|min:0|max:1',
        ];
    }
}
