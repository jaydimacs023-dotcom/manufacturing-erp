<?php

namespace Modules\Manufacturing\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWasteRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'waste_number' => 'nullable|string|max:50|unique:waste_records,waste_number',
            'manufacturing_order_id' => 'required|exists:manufacturing_orders,id',
            'production_output_id' => 'nullable|exists:production_outputs,id',
            'product_id' => 'required|exists:products,id',
            'uom_id' => 'required|exists:units_of_measure,id',
            'waste_type' => 'required|string|in:banana_peel,burnt_chips,oil_loss,rejected_product,packaging_damage,other',
            'quantity' => 'required|numeric|min:0',
            'reason' => 'required|string|max:500',
            'description' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
