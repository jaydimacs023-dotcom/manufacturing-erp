<?php

namespace Modules\Warehouse\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transfer_number' => 'nullable|string|max:50|unique:warehouse_transfers,transfer_number',
            'source_warehouse_id' => 'required|exists:warehouses,id',
            'source_location_id' => 'required|exists:storage_locations,id',
            'destination_warehouse_id' => 'required|exists:warehouses,id',
            'destination_location_id' => 'required|exists:storage_locations,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.0001',
            'batch_number' => 'nullable|string|max:100',
            'reason' => 'nullable|string|max:255',
            'transfer_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

