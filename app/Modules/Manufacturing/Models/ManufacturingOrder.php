<?php

namespace Modules\Manufacturing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Manufacturing\Enums\ManufacturingOrderStatus;

class ManufacturingOrder extends Model
{
    use SoftDeletes;

    protected $table = 'manufacturing_orders';

    protected $fillable = [
        'uuid',
        'mo_number',
        'product_id',
        'bill_of_material_id',
        'bom_version',
        'planned_quantity',
        'uom_id',
        'warehouse_id',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'status',
        'priority',
        'batch_number',
        'description',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'planned_quantity' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (ManufacturingOrder $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (ManufacturingOrder $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class);
    }

    public function uom()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\UnitOfMeasure::class, 'uom_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(ManufacturingOrderItem::class);
    }

    public function materialIssues()
    {
        return $this->hasMany(MaterialIssue::class);
    }

    public function productionOutputs()
    {
        return $this->hasMany(ProductionOutput::class);
    }

    public function wasteRecords()
    {
        return $this->hasMany(WasteRecord::class);
    }
}
