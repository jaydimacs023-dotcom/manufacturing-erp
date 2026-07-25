<?php

namespace Modules\ProductMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = [
        'uuid',
        'category_code',
        'category_name',
        'description',
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
        static::creating(function (ProductCategory $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (ProductCategory $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

