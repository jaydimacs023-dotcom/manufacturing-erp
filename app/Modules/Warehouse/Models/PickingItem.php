<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class PickingItem extends Model
{
    protected $table = 'picking_items';

    protected $fillable = [
        'picking_id', 'product_id', 'required_quantity',
        'picked_quantity', 'batch_number', 'storage_location_id', 'remarks',
    ];

    protected $casts = [
        'required_quantity' => 'decimal:4',
        'picked_quantity' => 'decimal:4',
    ];

    public function picking()
    {
        return $this->belongsTo(Picking::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class);
    }
}

