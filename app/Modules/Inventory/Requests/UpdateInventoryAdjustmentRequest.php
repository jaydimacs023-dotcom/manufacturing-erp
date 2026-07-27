<?php

namespace Modules\Inventory\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'adjustment_number' => 'nullable|string|max:50|unique:inventory_adjustments,adjustment_number,' . $this->route('inventory_adjustment')?->id,
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason' => 'required|string|in:physical_count,damage,spoilage,expired,missing,found,other',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|string|in:draft,pending_approval,approved,rejected,cancelled',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
