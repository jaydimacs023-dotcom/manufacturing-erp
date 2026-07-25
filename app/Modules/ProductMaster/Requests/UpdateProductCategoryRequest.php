<?php

namespace Modules\ProductMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_name' => 'required|string|max:255',
            'category_code' => 'nullable|string|max:50|unique:product_categories,category_code,' . $this->route('product_category')?->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }
}

