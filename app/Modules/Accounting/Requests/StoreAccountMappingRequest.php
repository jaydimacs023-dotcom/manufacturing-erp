<?php

namespace Modules\Accounting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountMappingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mapping_type' => 'required|string|max:50',
            'source_type' => 'required|string|max:50',
            'account_code' => 'required|string|max:50',
            'account_name' => 'required|string|max:200',
            'direction' => 'required|string|in:debit,credit',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ];
    }
}
