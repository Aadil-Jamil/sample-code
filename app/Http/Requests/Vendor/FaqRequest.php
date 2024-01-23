<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 * @bodyParam title string required The title is required.
 * @bodyParam details string required The details is required.
 * @bodyParam sorting integer optional The sorting is optional.
 * @bodyParam shop_id integer required The shop_id is required when admin store faq.
 *
 */


class FaqRequest extends FormRequest
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
            'title' => 'required|max:255',
            'details' => 'required|max:65535',
            'sorting' => 'sometimes|int',
            'shop_id' => auth()->user()?->hasRole('admin')  ? 'required|int|exists:shops,id' : 'nullable',
        ];
    }

    protected function update()
    {
        return [
            'title' => 'required|sometimes|max:255',
            'details' => 'required|sometimes|max:65535',
            'sorting' => 'sometimes|int',
            'shop_id' => auth()->user()?->hasRole('admin')  ? 'required|sometimes|int|exists:shops,id' : 'nullable',
        ];
    }
}
