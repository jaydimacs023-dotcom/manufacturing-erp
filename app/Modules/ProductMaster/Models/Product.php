<?php

namespace Modules\ProductMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'uuid',
        'product_code',
        'product_name',
        'product_type',
        'category_id',
        'default_uom_id',
        'description',
        'shelf_life_days',
        'is_active',
        'image_path',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'shelf_life_days' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Product $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Product $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function defaultUom()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'default_uom_id');
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }
}

