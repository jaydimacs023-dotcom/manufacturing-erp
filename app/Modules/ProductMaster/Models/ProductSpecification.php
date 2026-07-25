<?php

namespace Modules\ProductMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductSpecification extends Model
{
    protected $table = 'product_specifications';

    protected $fillable = [
        'uuid',
        'product_id',
        'spec_name',
        'spec_value',
        'created_by',
        'updated_by',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (ProductSpecification $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (ProductSpecification $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

