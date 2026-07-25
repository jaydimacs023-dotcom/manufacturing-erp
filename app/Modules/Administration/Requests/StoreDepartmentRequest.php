<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_name' => 'required|string|max:255',
            'department_code' => 'nullable|string|max:50|unique:departments,department_code',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }
}

