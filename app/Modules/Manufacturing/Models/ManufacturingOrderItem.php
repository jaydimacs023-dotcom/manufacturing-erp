<?php

namespace Modules\Manufacturing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ManufacturingOrderItem extends Model
{
    protected $table = 'manufacturing_order_items';

    protected $fillable = [
        'uuid',
        'manufacturing_order_id',
        'product_id',
        'uom_id',
        'planned_quantity',
        'issued_quantity',
        'unit_cost',
        'total_cost',
        'batch_number',
        'remarks',
    ];

    protected $casts = [
        'planned_quantity' => 'decimal:4',
        'issued_quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'total_cost' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (ManufacturingOrderItem $model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function manufacturingOrder()
    {
        return $this->belongsTo(ManufacturingOrder::class);
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
