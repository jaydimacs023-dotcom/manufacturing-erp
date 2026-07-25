<?php

namespace Modules\ProductMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'product_code' => 'nullable|string|max:50|unique:products,product_code,' . $this->route('product')?->id,
            'product_type' => 'required|string|max:50|in:raw_material,packaging,finished_good,consumable',
            'category_id' => 'required|exists:product_categories,id',
            'default_uom_id' => 'required|exists:units_of_measure,id',
            'description' => 'nullable|string|max:5000',
            'shelf_life_days' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}

