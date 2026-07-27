<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InspectionType extends Model
{
    protected $table = 'inspection_types';

    protected $fillable = [
        'uuid', 'code', 'name', 'description', 'category', 'is_active',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (InspectionType $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (InspectionType $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function checklists()
    {
        return $this->hasMany(QualityChecklist::class, 'inspection_type_id');
    }

    public function inspections()
    {
        return $this->hasMany(QualityInspection::class, 'inspection_type_id');
    }
}

