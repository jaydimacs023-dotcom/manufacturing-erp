<?php

namespace Modules\Warehouse\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePutawayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'putaway_number' => 'nullable|string|max:50|unique:putaways,putaway_number',
            'warehouse_id' => 'required|exists:warehouses,id',
            'storage_location_id' => 'required|exists:storage_locations,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0',
            'batch_number' => 'nullable|string|max:100',
            'source_type' => 'required|string|max:50',
            'source_id' => 'required|integer',
            'reference_type' => 'nullable|string|max:50',
            'reference_number' => 'nullable|string|max:50',
            'putaway_date' => 'required|date',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

