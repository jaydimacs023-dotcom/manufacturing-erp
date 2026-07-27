<?php

namespace Modules\Sales\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExportOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('export_order')?->id ?? 'null';
        return [
            'export_order_number' => 'nullable|string|max:50|unique:export_orders,export_order_number,' . $id,
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
            'items' => 'nullable|array|min:1',
            'items.*.sales_order_id' => 'required_with:items|exists:sales_orders,id',
            'items.*.sales_order_item_id' => 'required_with:items|exists:sales_order_items,id',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity' => 'required_with:items|numeric|min:0.0001',
        ];
    }
}

