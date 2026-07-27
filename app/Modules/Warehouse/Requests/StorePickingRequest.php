<?php

namespace Modules\Warehouse\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePickingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'picking_number' => 'nullable|string|max:50|unique:pickings,picking_number',
            'warehouse_id' => 'required|exists:warehouses,id',
            'picking_type' => 'required|string|in:production,shipment,transfer',
            'reference_type' => 'required|string',
            'reference_id' => 'required|integer',
            'reference_number' => 'nullable|string|max:50',
            'picking_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.required_quantity' => 'required|numeric|min:0.0001',
            'items.*.storage_location_id' => 'nullable|exists:storage_locations,id',
            'items.*.batch_number' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.*.product_id.required' => 'Each item must have a product.',
            'items.*.required_quantity.required' => 'Each item must have a required quantity.',
        ];
    }
}

