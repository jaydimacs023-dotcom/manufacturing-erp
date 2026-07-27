<?php

namespace Modules\QualityControl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorrectiveActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quality_inspection_id' => 'required|exists:quality_inspections,id',
            'non_conformance_id' => 'nullable|exists:non_conformances,id',
            'action_type' => 'required|string|in:rework,re_inspection,disposal,supplier_return',
            'description' => 'required|string|max:1000',
            'action_taken' => 'nullable|string|max:1000',
            'responsible_person_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ];
    }
}

