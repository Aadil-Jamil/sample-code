<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PageIndexRequest extends FormRequest
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
        $rules = [
            'sort_by' => ['nullable', Rule::in(DB::getSchemaBuilder()->getColumnListing('pages'))],
            'order_by' => 'nullable|in:asc,desc',
            'search' => 'nullable|string',
            'paginate' => 'nullable|boolean',
            'page_size' => 'int',
        ];
    
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            $rules['shop_id'] = 'required|exists:shops,id';
        }
    
        return $rules;
    }
}
