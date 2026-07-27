<?php

namespace Modules\Inventory\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transfer_number' => 'nullable|string|max:50|unique:inventory_transfers,transfer_number',
            'from_warehouse_id' => 'required|exists:warehouses,id|different:to_warehouse_id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'transfer_date' => 'required|date',
            'status' => 'nullable|string|in:draft,completed,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.batch_number' => 'nullable|string|max:100',
            'items.*.expiry_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'from_warehouse_id.different' => 'Source and destination warehouses must be different.',
            'to_warehouse_id.different' => 'Source and destination warehouses must be different.',
            'items.required' => 'At least one item is required.',
            'items.*.quantity.min' => 'The transfer quantity must be greater than zero.',
        ];
    }
}
