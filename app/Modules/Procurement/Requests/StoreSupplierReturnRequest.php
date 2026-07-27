<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_return_number' => 'nullable|string|max:50|unique:supplier_returns,supplier_return_number',
            'goods_receipt_id' => 'required|exists:goods_receipts,id',
            'return_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason' => 'required|string|max:255',
            'status' => 'nullable|string|in:draft,completed,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.goods_receipt_item_id' => 'required|exists:goods_receipt_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity_returned' => 'required|numeric|min:0.0001',
            'items.*.reason' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.*.quantity_returned.min' => 'The returned quantity must be greater than zero.',
        ];
    }
}

