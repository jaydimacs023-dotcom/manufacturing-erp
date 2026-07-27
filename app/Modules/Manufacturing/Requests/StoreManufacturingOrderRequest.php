<?php

namespace Modules\Manufacturing\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManufacturingOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mo_number' => 'nullable|string|max:50|unique:manufacturing_orders,mo_number',
            'product_id' => 'required|exists:products,id',
            'bill_of_material_id' => 'nullable|exists:bill_of_materials,id',
            'bom_version' => 'nullable|string|max:20',
            'planned_quantity' => 'required|numeric|min:0',
            'uom_id' => 'required|exists:units_of_measure,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'required|date|after_or_equal:planned_start_date',
            'priority' => 'nullable|string|in:low,normal,high,urgent',
            'description' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
