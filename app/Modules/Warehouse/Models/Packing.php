<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Packing extends Model
{
    use SoftDeletes;

    protected $table = 'packings';

    protected $fillable = [
        'uuid', 'packing_number', 'packing_type',
        'warehouse_id',
        'reference_type', 'reference_id', 'reference_number',
        'product_id', 'quantity', 'carton_count',
        'gross_weight', 'net_weight', 'weight_uom',
        'status', 'packing_date', 'remarks',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'gross_weight' => 'decimal:4',
        'net_weight' => 'decimal:4',
        'packing_date' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Packing $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Packing $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }
}

