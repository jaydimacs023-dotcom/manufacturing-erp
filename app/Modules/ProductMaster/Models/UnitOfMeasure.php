<?php

namespace Modules\ProductMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UnitOfMeasure extends Model
{
    use SoftDeletes;

    protected $table = 'units_of_measure';

    protected $fillable = [
        'uuid',
        'uom_code',
        'uom_name',
        'uom_type',
        'is_active',
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
        static::creating(function (UnitOfMeasure $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (UnitOfMeasure $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'default_uom_id');
    }
}

