<?php

namespace Modules\Sales\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackingListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'packing_list_number' => 'nullable|string|max:50|unique:packing_lists,packing_list_number',
            'export_order_id' => 'required|exists:export_orders,id',
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'nullable|string|max:100',
            'quantity' => 'required|numeric|min:0.0001',
            'number_of_cartons' => 'nullable|integer|min:1',
            'net_weight' => 'nullable|numeric|min:0',
            'gross_weight' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

