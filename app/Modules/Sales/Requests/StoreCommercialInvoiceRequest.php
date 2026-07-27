<?php

namespace Modules\Sales\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommercialInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_number' => 'nullable|string|max:50|unique:commercial_invoices,invoice_number',
            'export_order_id' => 'required|exists:export_orders,id',
            'customer_id' => 'required|exists:business_partners,id',
            'total_amount' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}

