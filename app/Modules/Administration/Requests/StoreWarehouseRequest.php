<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_name' => 'required|string|max:255',
            'warehouse_code' => 'nullable|string|max:50|unique:warehouses,warehouse_code',
            'warehouse_type' => 'required|string|in:raw_material,packaging,production,finished_goods,transit',
            'address' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'branch_id' => 'required|exists:branches,id',
        ];
    }
}

