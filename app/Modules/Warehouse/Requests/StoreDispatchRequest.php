<?php

namespace Modules\Warehouse\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDispatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dispatch_number' => 'nullable|string|max:50|unique:dispatches,dispatch_number',
            'warehouse_id' => 'required|exists:warehouses,id',
            'dispatch_type' => 'required|string|in:sales,export,transfer',
            'reference_type' => 'required|string',
            'reference_id' => 'required|integer',
            'reference_number' => 'nullable|string|max:50',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.0001',
            'batch_number' => 'nullable|string|max:100',
            'destination' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'container_number' => 'nullable|string|max:50',
            'seal_number' => 'nullable|string|max:50',
            'dispatch_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

