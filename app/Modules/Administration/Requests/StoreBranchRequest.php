<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_name' => 'required|string|max:255',
            'branch_code' => 'nullable|string|max:50|unique:branches,branch_code',
            'address' => 'nullable|string|max:1000',
            'contact_number' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}

