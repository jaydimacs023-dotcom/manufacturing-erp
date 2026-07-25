<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branchId = $this->route('branch');
        return [
            'branch_name' => 'required|string|max:255',
            'branch_code' => 'nullable|string|max:50|unique:branches,branch_code,' . $branchId,
            'address' => 'nullable|string|max:1000',
            'contact_number' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}

