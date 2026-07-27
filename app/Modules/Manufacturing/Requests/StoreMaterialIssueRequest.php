<?php

namespace Modules\Manufacturing\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'issue_number' => 'nullable|string|max:50|unique:material_issues,issue_number',
            'manufacturing_order_id' => 'required|exists:manufacturing_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'issue_date' => 'nullable|date',
            'status' => 'nullable|string|in:draft,completed,cancelled',
            'issued_by' => 'nullable|exists:users,id',
            'received_by' => 'nullable|exists:users,id',
            'description' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.uom_id' => 'required|exists:units_of_measure,id',
            'items.*.quantity_issued' => 'required|numeric|min:0',
            'items.*.unit_cost' => 'nullable|numeric|min:0',
            'items.*.batch_number' => 'nullable|string|max:100',
            'items.*.manufacturing_order_item_id' => 'nullable|exists:manufacturing_order_items,id',
            'items.*.remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one material item is required.',
            'items.*.product_id.required' => 'The product is required for each item.',
            'items.*.quantity_issued.required' => 'The issued quantity is required for each item.',
        ];
    }
}
