<?php

namespace Modules\BusinessPartner\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $paymentTerm = $this->route('payment_term');
        return [
            'term_code' => 'nullable|string|max:50|unique:payment_terms,term_code,' . $paymentTerm,
            'term_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'due_days' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}

