<?php

namespace Modules\Procurement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'request_number' => 'nullable|string|max:50|unique:purchase_requests,request_number,' . $this->route('purchase_request')?->id,
            'request_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'required_date' => 'required|date|after_or_equal:request_date',
            'priority' => 'required|string|in:low,normal,high,urgent',
            'requested_by' => 'required|string|max:255',
            'status' => 'nullable|string|in:draft,submitted,approved,rejected,converted_to_po,cancelled',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}

