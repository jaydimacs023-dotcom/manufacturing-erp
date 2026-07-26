<?php

namespace Modules\BusinessPartner\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessPartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'partner_name' => 'required|string|max:255',
            'partner_code' => 'nullable|string|max:50|unique:business_partners,partner_code',
            'partner_type' => 'required|string|max:50|in:supplier,customer,freight_forwarder,customs_broker,service_provider',
            'tax_identification_number' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:2000',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'payment_term_id' => 'nullable|exists:payment_terms,id',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ];
    }
}

