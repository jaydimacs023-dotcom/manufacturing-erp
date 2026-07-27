<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StockReservation extends Model
{
    protected $table = 'stock_reservations';

    protected $fillable = [
        'uuid',
        'product_id',
        'warehouse_id',
        'reference_type',
        'reference_id',
        'quantity_reserved',
        'quantity_consumed',
        'batch_number',
        'status',
        'reserved_until',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'quantity_reserved' => 'decimal:4',
        'quantity_consumed' => 'decimal:4',
        'reserved_until' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (StockReservation $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }
}

