<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QualityChecklist extends Model
{
    protected $table = 'quality_checklists';

    protected $fillable = [
        'uuid', 'code', 'name', 'description', 'inspection_type_id',
        'product_id', 'is_active', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (QualityChecklist $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (QualityChecklist $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function inspectionType()
    {
        return $this->belongsTo(InspectionType::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function items()
    {
        return $this->hasMany(QualityChecklistItem::class, 'quality_checklist_id');
    }
}

