<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SupplierReturn extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_returns';

    protected $fillable = [
        'uuid',
        'supplier_return_number',
        'goods_receipt_id',
        'return_date',
        'warehouse_id',
        'reason',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'return_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (SupplierReturn $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (SupplierReturn $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(SupplierReturnItem::class);
    }
}

