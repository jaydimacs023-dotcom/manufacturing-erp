<?php

namespace Modules\QualityControl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQualityInspectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inspection_type' => 'sometimes|string|in:incoming,in_process,final',
            'inspection_type_id' => 'nullable|exists:inspection_types,id',
            'quality_checklist_id' => 'nullable|exists:quality_checklists,id',
            'product_id' => 'sometimes|exists:products,id',
            'quantity_inspected' => 'nullable|numeric|min:0',
            'quantity_passed' => 'nullable|numeric|min:0',
            'quantity_failed' => 'nullable|numeric|min:0',
            'batch_number' => 'nullable|string|max:50',
            'lot_number' => 'nullable|string|max:50',
            'inspector_id' => 'nullable|exists:users,id',
            'inspection_date' => 'sometimes|date',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

