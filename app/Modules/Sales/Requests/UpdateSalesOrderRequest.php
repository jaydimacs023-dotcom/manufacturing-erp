<?php

namespace Modules\Sales\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('sales_order')?->id ?? 'null';
        return [
            'sales_order_number' => 'nullable|string|max:50|unique:sales_orders,sales_order_number,' . $id,
            'customer_id' => 'required|exists:business_partners,id',
            'order_date' => 'nullable|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'currency' => 'nullable|string|max:3',
            'notes' => 'nullable|string|max:1000',
            'items' => 'nullable|array|min:1',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity' => 'required_with:items|numeric|min:0.0001',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
        ];
    }
}

