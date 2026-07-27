<?php

namespace Modules\Manufacturing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WasteRecord extends Model
{
    protected $table = 'waste_records';

    protected $fillable = [
        'uuid',
        'waste_number',
        'manufacturing_order_id',
        'production_output_id',
        'product_id',
        'uom_id',
        'waste_type',
        'quantity',
        'reason',
        'description',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (WasteRecord $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    public function manufacturingOrder()
    {
        return $this->belongsTo(ManufacturingOrder::class);
    }

    public function productionOutput()
    {
        return $this->belongsTo(ProductionOutput::class);
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
