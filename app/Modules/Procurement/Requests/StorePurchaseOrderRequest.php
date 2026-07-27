<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_order_number' => 'nullable|string|max:50|unique:purchase_orders,purchase_order_number',
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:business_partners,id',
            'delivery_address' => 'nullable|string|max:1000',
            'expected_delivery_date' => 'required|date',
            'payment_term_id' => 'nullable|exists:payment_terms,id',
            'currency' => 'nullable|string|size:3',
            'status' => 'nullable|string|in:draft,approved,sent,partially_received,fully_received,closed,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.purchase_request_item_id' => 'nullable|exists:purchase_request_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity_ordered' => 'required|numeric|min:0.0001',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.*.quantity_ordered.min' => 'The quantity must be greater than zero.',
            'items.*.unit_cost.min' => 'The unit cost must not be negative.',
        ];
    }
}

