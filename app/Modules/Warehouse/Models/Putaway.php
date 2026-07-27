<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Putaway extends Model
{
    use SoftDeletes;

    protected $table = 'putaways';

    protected $fillable = [
        'uuid', 'putaway_number', 'warehouse_id', 'storage_location_id',
        'product_id', 'quantity', 'batch_number',
        'source_type', 'source_id', 'reference_type', 'reference_number',
        'status', 'putaway_date', 'remarks', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'putaway_date' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Putaway $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Putaway $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }

    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function source()
    {
        return $this->morphTo();
    }
}

