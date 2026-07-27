<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGoodsReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'goods_receipt_number' => 'nullable|string|max:50|unique:goods_receipts,goods_receipt_number,' . $this->route('goods_receipt')?->id,
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'delivery_receipt_number' => 'nullable|string|max:100',
            'supplier_invoice_number' => 'nullable|string|max:100',
            'date_received' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'received_by' => 'required|string|max:255',
            'status' => 'nullable|string|in:draft,completed,cancelled',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

