<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InventoryTransfer extends Model
{
    use SoftDeletes;

    protected $table = 'inventory_transfers';

    protected $fillable = [
        'uuid',
        'transfer_number',
        'from_warehouse_id',
        'to_warehouse_id',
        'transfer_date',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (InventoryTransfer $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (InventoryTransfer $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class, 'to_warehouse_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryTransferItem::class);
    }
}

