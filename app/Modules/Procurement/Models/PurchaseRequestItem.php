<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseRequestItem extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_request_items';

    protected $fillable = [
        'uuid',
        'purchase_request_id',
        'product_id',
        'uom_id',
        'quantity',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PurchaseRequestItem $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (PurchaseRequestItem $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
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

