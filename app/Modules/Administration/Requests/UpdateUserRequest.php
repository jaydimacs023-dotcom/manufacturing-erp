<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8',
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ];
    }
}

