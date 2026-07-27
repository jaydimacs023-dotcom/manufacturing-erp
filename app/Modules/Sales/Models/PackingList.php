<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PackingList extends Model
{
    use SoftDeletes;

    protected $table = 'packing_lists';

    protected $fillable = [
        'uuid', 'packing_list_number', 'export_order_id',
        'product_id', 'batch_number', 'quantity',
        'number_of_cartons', 'net_weight', 'gross_weight',
        'remarks', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'net_weight' => 'decimal:2',
        'gross_weight' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PackingList $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (PackingList $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function exportOrder()
    {
        return $this->belongsTo(ExportOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }
}

