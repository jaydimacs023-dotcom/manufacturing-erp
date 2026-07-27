<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_order_number' => 'nullable|string|max:50|unique:purchase_orders,purchase_order_number,' . $this->route('purchase_order')?->id,
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:business_partners,id',
            'delivery_address' => 'nullable|string|max:1000',
            'expected_delivery_date' => 'required|date',
            'payment_term_id' => 'nullable|exists:payment_terms,id',
            'currency' => 'nullable|string|size:3',
            'status' => 'nullable|string|in:draft,approved,sent,partially_received,fully_received,closed,cancelled',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

