<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DefectType extends Model
{
    protected $table = 'defect_types';

    protected $fillable = [
        'uuid', 'code', 'name', 'description', 'severity', 'is_active',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (DefectType $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (DefectType $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function nonConformances()
    {
        return $this->hasMany(NonConformance::class, 'defect_type_id');
    }
}

