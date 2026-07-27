<?php

namespace Modules\Manufacturing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BillOfMaterial extends Model
{
    use SoftDeletes;

    protected $table = 'bill_of_materials';

    protected $fillable = [
        'uuid',
        'bom_number',
        'product_id',
        'version',
        'effective_date',
        'status',
        'total_quantity',
        'uom_id',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'is_active' => 'boolean',
        'total_quantity' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (BillOfMaterial $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (BillOfMaterial $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function uom()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\UnitOfMeasure::class, 'uom_id');
    }

    public function items()
    {
        return $this->hasMany(BillOfMaterialItem::class);
    }

    public function manufacturingOrders()
    {
        return $this->hasMany(ManufacturingOrder::class);
    }
}
