<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Dispatch extends Model
{
    use SoftDeletes;

    protected $table = 'dispatches';

    protected $fillable = [
        'uuid', 'dispatch_number', 'warehouse_id',
        'dispatch_type', 'status',
        'reference_type', 'reference_id', 'reference_number',
        'product_id', 'quantity', 'batch_number',
        'destination', 'vehicle_number', 'container_number', 'seal_number',
        'dispatch_date', 'loaded_at', 'dispatched_at',
        'confirmed_by', 'remarks',
        'approved_by', 'approved_at',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'dispatch_date' => 'datetime',
        'loaded_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Dispatch $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Dispatch $model) {
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

    public function confirmer()
    {
        return $this->belongsTo(\App\Models\User::class, 'confirmed_by');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}

