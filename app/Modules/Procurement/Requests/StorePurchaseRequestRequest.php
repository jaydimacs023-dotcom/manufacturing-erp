<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'request_number' => 'nullable|string|max:50|unique:purchase_requests,request_number',
            'request_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'required_date' => 'required|date|after_or_equal:request_date',
            'priority' => 'required|string|in:low,normal,high,urgent',
            'requested_by' => 'required|string|max:255',
            'status' => 'nullable|string|in:draft,submitted,approved,rejected,converted_to_po,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.*.quantity.min' => 'The quantity must be greater than zero.',
        ];
    }
}

