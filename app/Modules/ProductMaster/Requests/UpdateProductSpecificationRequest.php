<?php

namespace Modules\ProductMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductSpecificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'spec_name' => 'required|string|max:100',
            'spec_value' => 'required|string|max:255',
        ];
    }
}

