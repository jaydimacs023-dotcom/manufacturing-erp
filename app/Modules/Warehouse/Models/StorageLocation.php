<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StorageLocation extends Model
{
    use SoftDeletes;

    protected $table = 'storage_locations';

    protected $fillable = [
        'uuid', 'warehouse_id', 'location_code', 'storage_area', 'rack', 'bin',
        'description', 'max_capacity', 'uom_code', 'is_active', 'remarks',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_capacity' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (StorageLocation $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (StorageLocation $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function warehouse()
    {
        return $this->belongsTo(\Modules\Administration\Models\Warehouse::class);
    }

    public function putaways()
    {
        return $this->hasMany(Putaway::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

