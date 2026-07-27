<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class ExportOrderItem extends Model
{
    protected $table = 'export_order_items';

    protected $fillable = [
        'export_order_id', 'sales_order_id', 'sales_order_item_id',
        'product_id', 'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    public function exportOrder()
    {
        return $this->belongsTo(ExportOrder::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function salesOrderItem()
    {
        return $this->belongsTo(SalesOrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }
}

