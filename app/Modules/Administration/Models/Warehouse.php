<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $table = 'warehouses';

    protected $fillable = [
        'uuid',
        'warehouse_code',
        'warehouse_name',
        'warehouse_type',
        'address',
        'is_active',
        'branch_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Warehouse $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Warehouse $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

