<?php

namespace Modules\Sales\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExportOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'export_order_number' => 'nullable|string|max:50|unique:export_orders,export_order_number',
            'customer_id' => 'required|exists:business_partners,id',
            'destination_country' => 'required|string|max:100',
            'port_of_loading' => 'nullable|string|max:100',
            'port_of_destination' => 'nullable|string|max:100',
            'vessel' => 'nullable|string|max:100',
            'etd' => 'nullable|date',
            'eta' => 'nullable|date|after_or_equal:etd',
            'container_number' => 'nullable|string|max:50',
            'seal_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.sales_order_id' => 'required|exists:sales_orders,id',
            'items.*.sales_order_item_id' => 'required|exists:sales_order_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
        ];
    }
}

