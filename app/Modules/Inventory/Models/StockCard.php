<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StockCard extends Model
{
    protected $table = 'stock_cards';

    protected $fillable = [
        'uuid',
        'product_id',
        'warehouse_id',
        'quantity_on_hand',
        'quantity_reserved',
        'quantity_available',
        'quantity_in_transit',
        'quantity_quarantine',
        'batch_number',
        'expiry_date',
        'unit_cost',
    ];

    protected $casts = [
        'quantity_on_hand' => 'decimal:4',
        'quantity_reserved' => 'decimal:4',
        'quantity_available' => 'decimal:4',
        'quantity_in_transit' => 'decimal:4',
        'quantity_quarantine' => 'decimal:4',
        'unit_cost' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (StockCard $model) {
            $model->uuid = (string) Str::uuid();
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

