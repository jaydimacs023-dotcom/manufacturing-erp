<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WarehouseTransfer extends Model
{
    use SoftDeletes;

    protected $table = 'warehouse_transfers';

    protected $fillable = [
        'uuid', 'transfer_number',
        'source_warehouse_id', 'source_location_id',
        'destination_warehouse_id', 'destination_location_id',
        'product_id', 'quantity', 'batch_number',
        'status', 'reason', 'transfer_date', 'remarks',
        'approved_by', 'approved_at',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'transfer_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (WarehouseTransfer $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (WarehouseTransfer $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function sourceWarehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class, 'source_warehouse_id');
    }

    public function sourceLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'source_location_id');
    }

    public function destinationWarehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class, 'destination_warehouse_id');
    }

    public function destinationLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'destination_location_id');
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}

