<?php

namespace Modules\Manufacturing\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionOutputRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'output_number' => 'nullable|string|max:50|unique:production_outputs,output_number',
            'manufacturing_order_id' => 'required|exists:manufacturing_orders,id',
            'product_id' => 'required|exists:products,id',
            'uom_id' => 'required|exists:units_of_measure,id',
            'quantity_produced' => 'required|numeric|min:0',
            'quantity_rejected' => 'nullable|numeric|min:0',
            'quantity_waste' => 'nullable|numeric|min:0',
            'batch_number' => 'nullable|string|max:100',
            'warehouse_id' => 'required|exists:warehouses,id',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
