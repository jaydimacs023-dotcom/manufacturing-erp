<?php

namespace Modules\Manufacturing\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBillOfMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bomId = $this->route('bill_of_material');
        return [
            'bom_number' => 'nullable|string|max:50|unique:bill_of_materials,bom_number,' . $bomId,
            'product_id' => 'required|exists:products,id',
            'version' => 'required|string|max:20',
            'effective_date' => 'required|date',
            'status' => 'nullable|string|in:draft,active,approved,inactive,archived',
            'total_quantity' => 'required|numeric|min:0',
            'uom_id' => 'required|exists:units_of_measure,id',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.uom_id' => 'required_with:items|exists:units_of_measure,id',
            'items.*.quantity' => 'required_with:items|numeric|min:0',
            'items.*.waste_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.unit_cost' => 'nullable|numeric|min:0',
            'items.*.remarks' => 'nullable|string|max:500',
        ];
    }
}
