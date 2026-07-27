<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseOrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_order_items';

    protected $fillable = [
        'uuid',
        'purchase_order_id',
        'purchase_request_item_id',
        'product_id',
        'uom_id',
        'quantity_ordered',
        'unit_cost',
        'total_cost',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'quantity_ordered' => 'decimal:4',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PurchaseOrderItem $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (PurchaseOrderItem $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function purchaseRequestItem()
    {
        return $this->belongsTo(PurchaseRequestItem::class, 'purchase_request_item_id');
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function uom()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\UnitOfMeasure::class, 'uom_id');
    }
}

