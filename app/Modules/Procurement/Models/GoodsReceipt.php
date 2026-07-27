<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GoodsReceipt extends Model
{
    use SoftDeletes;

    protected $table = 'goods_receipts';

    protected $fillable = [
        'uuid',
        'goods_receipt_number',
        'purchase_order_id',
        'delivery_receipt_number',
        'supplier_invoice_number',
        'date_received',
        'warehouse_id',
        'received_by',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'date_received' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (GoodsReceipt $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (GoodsReceipt $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }

    public function supplierReturns()
    {
        return $this->hasMany(SupplierReturn::class);
    }
}

