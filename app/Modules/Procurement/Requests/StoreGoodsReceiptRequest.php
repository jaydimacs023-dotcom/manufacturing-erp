<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoodsReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'goods_receipt_number' => 'nullable|string|max:50|unique:goods_receipts,goods_receipt_number',
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'delivery_receipt_number' => 'nullable|string|max:100',
            'supplier_invoice_number' => 'nullable|string|max:100',
            'date_received' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'received_by' => 'required|string|max:255',
            'status' => 'nullable|string|in:draft,completed,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.purchase_order_item_id' => 'required|exists:purchase_order_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity_ordered' => 'required|numeric|min:0',
            'items.*.quantity_received' => 'required|numeric|min:0.0001',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.batch_number' => 'nullable|string|max:100',
            'items.*.expiry_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.*.quantity_received.min' => 'The received quantity must be greater than zero.',
        ];
    }
}

