<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_return_number' => 'nullable|string|max:50|unique:supplier_returns,supplier_return_number,' . $this->route('supplier_return')?->id,
            'goods_receipt_id' => 'required|exists:goods_receipts,id',
            'return_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason' => 'required|string|max:255',
            'status' => 'nullable|string|in:draft,completed,cancelled',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

