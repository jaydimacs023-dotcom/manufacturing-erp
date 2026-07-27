<?php

namespace Modules\Manufacturing\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillOfMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bom_number' => 'nullable|string|max:50|unique:bill_of_materials,bom_number',
            'product_id' => 'required|exists:products,id',
            'version' => 'required|string|max:20',
            'effective_date' => 'required|date',
            'status' => 'nullable|string|in:draft,active,approved,inactive,archived',
            'total_quantity' => 'required|numeric|min:0',
            'uom_id' => 'required|exists:units_of_measure,id',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.waste_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.unit_cost' => 'nullable|numeric|min:0',
            'items.*.remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one BOM item is required.',
            'items.*.product_id.required' => 'The product is required for each item.',
            'items.*.quantity.required' => 'The quantity is required for each item.',
        ];
    }
}
