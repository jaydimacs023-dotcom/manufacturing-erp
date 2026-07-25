<?php

namespace Modules\ProductMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitOfMeasureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uom_code' => 'required|string|max:20|unique:units_of_measure,uom_code,' . $this->route('units_of_measure')?->id,
            'uom_name' => 'required|string|max:100',
            'uom_type' => 'required|string|max:50|in:reference,transactional',
            'is_active' => 'boolean',
        ];
    }
}

