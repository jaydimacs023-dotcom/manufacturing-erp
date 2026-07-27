<?php

namespace Modules\Inventory\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'adjustment_number' => 'nullable|string|max:50|unique:inventory_adjustments,adjustment_number',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason' => 'required|string|in:physical_count,damage,spoilage,expired,missing,found,other',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|string|in:draft,pending_approval,approved,rejected,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.expected_quantity' => 'required|numeric|min:0',
            'items.*.actual_quantity' => 'required|numeric|min:0',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.batch_number' => 'nullable|string|max:100',
            'items.*.expiry_date' => 'nullable|date',
            'items.*.remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.*.expected_quantity.required' => 'The expected quantity is required for each item.',
            'items.*.actual_quantity.required' => 'The actual quantity is required for each item.',
        ];
    }
}
