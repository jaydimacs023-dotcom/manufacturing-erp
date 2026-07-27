<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QualityInspection extends Model
{
    protected $table = 'quality_inspections';

    protected $fillable = [
        'uuid', 'inspection_number', 'inspection_type', 'status',
        'inspection_type_id', 'quality_checklist_id',
        'inspection_source_type', 'inspection_source_id',
        'product_id', 'quantity_inspected', 'quantity_passed', 'quantity_failed',
        'batch_number', 'lot_number', 'inspector_id', 'inspection_date',
        'completed_at', 'remarks', 'approved_by', 'approved_at',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'inspection_date' => 'datetime',
        'completed_at' => 'datetime',
        'approved_at' => 'datetime',
        'quantity_inspected' => 'decimal:4',
        'quantity_passed' => 'decimal:4',
        'quantity_failed' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (QualityInspection $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
            if (!$model->inspection_date) {
                $model->inspection_date = now();
            }
        });
        static::updating(function (QualityInspection $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function inspectionType()
    {
        return $this->belongsTo(InspectionType::class);
    }

    public function checklist()
    {
        return $this->belongsTo(QualityChecklist::class, 'quality_checklist_id');
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function inspector()
    {
        return $this->belongsTo(\App\Models\User::class, 'inspector_id');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(QualityInspectionItem::class, 'quality_inspection_id');
    }

    public function inspectionSource()
    {
        return $this->morphTo();
    }

    public function nonConformances()
    {
        return $this->hasMany(NonConformance::class, 'quality_inspection_id');
    }

    public function correctiveActions()
    {
        return $this->hasMany(CorrectiveAction::class, 'quality_inspection_id');
    }
}

