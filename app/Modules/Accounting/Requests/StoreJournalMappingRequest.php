<?php

namespace Modules\Accounting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJournalMappingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_type' => 'required|string|max:50|unique:journal_mappings,transaction_type',
            'debit_account_code' => 'nullable|string|max:50',
            'debit_account_name' => 'nullable|string|max:200',
            'credit_account_code' => 'nullable|string|max:50',
            'credit_account_name' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ];
    }
}
