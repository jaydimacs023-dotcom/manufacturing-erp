<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseOrder extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'uuid',
        'purchase_order_number',
        'purchase_request_id',
        'supplier_id',
        'delivery_address',
        'expected_delivery_date',
        'payment_term_id',
        'currency',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PurchaseOrder $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (PurchaseOrder $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function supplier()
    {
        return $this->belongsTo(\Modules\BusinessPartner\Models\BusinessPartner::class, 'supplier_id');
    }

    public function paymentTerm()
    {
        return $this->belongsTo(\Modules\BusinessPartner\Models\PaymentTerm::class, 'payment_term_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }
}

