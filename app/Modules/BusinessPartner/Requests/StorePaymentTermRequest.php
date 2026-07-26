<?php

namespace Modules\BusinessPartner\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'term_code' => 'nullable|string|max:50|unique:payment_terms,term_code',
            'term_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'due_days' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}

