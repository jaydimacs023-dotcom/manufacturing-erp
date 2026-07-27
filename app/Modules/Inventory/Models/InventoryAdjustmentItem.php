<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryAdjustmentItem extends Model
{
    protected $table = 'inventory_adjustment_items';

    protected $fillable = [
        'uuid',
        'inventory_adjustment_id',
        'product_id',
        'uom_id',
        'expected_quantity',
        'actual_quantity',
        'difference',
        'unit_cost',
        'batch_number',
        'expiry_date',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'expected_quantity' => 'decimal:4',
        'actual_quantity' => 'decimal:4',
        'difference' => 'decimal:4',
        'unit_cost' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (InventoryAdjustmentItem $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    public function inventoryAdjustment()
    {
        return $this->belongsTo(InventoryAdjustment::class);
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

