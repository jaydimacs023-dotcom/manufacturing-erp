<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SupplierReturnItem extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_return_items';

    protected $fillable = [
        'uuid',
        'supplier_return_id',
        'goods_receipt_item_id',
        'product_id',
        'uom_id',
        'quantity_returned',
        'reason',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'quantity_returned' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (SupplierReturnItem $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (SupplierReturnItem $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function supplierReturn()
    {
        return $this->belongsTo(SupplierReturn::class);
    }

    public function goodsReceiptItem()
    {
        return $this->belongsTo(GoodsReceiptItem::class);
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

