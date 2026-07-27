<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GoodsReceiptItem extends Model
{
    use SoftDeletes;

    protected $table = 'goods_receipt_items';

    protected $fillable = [
        'uuid',
        'goods_receipt_id',
        'purchase_order_item_id',
        'product_id',
        'uom_id',
        'quantity_ordered',
        'quantity_received',
        'unit_cost',
        'batch_number',
        'expiry_date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'quantity_ordered' => 'decimal:4',
        'quantity_received' => 'decimal:4',
        'unit_cost' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (GoodsReceiptItem $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (GoodsReceiptItem $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class);
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

