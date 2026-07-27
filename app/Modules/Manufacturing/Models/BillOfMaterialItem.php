<?php

namespace Modules\Manufacturing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BillOfMaterialItem extends Model
{
    protected $table = 'bill_of_material_items';

    protected $fillable = [
        'uuid',
        'bill_of_material_id',
        'product_id',
        'uom_id',
        'quantity',
        'waste_percentage',
        'unit_cost',
        'total_cost',
        'is_active',
        'remarks',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'waste_percentage' => 'decimal:2',
        'unit_cost' => 'decimal:4',
        'total_cost' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (BillOfMaterialItem $model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class);
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
