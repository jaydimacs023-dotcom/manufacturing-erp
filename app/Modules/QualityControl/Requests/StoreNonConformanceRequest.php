<?php

namespace Modules\QualityControl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNonConformanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quality_inspection_id' => 'required|exists:quality_inspections,id',
            'defect_type_id' => 'nullable|exists:defect_types,id',
            'defect_type' => 'required|string|max:100',
            'severity' => 'required|string|in:minor,major,critical',
            'quantity_affected' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'root_cause' => 'nullable|string|max:500',
            'recommended_action' => 'nullable|string|max:500',
            'responsible_department' => 'nullable|string|max:100',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}

