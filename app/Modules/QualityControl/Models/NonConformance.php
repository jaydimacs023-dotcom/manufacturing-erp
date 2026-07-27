<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NonConformance extends Model
{
    protected $table = 'non_conformances';

    protected $fillable = [
        'uuid', 'nc_number', 'quality_inspection_id', 'defect_type_id',
        'defect_type', 'severity', 'quantity_affected', 'description',
        'root_cause', 'recommended_action', 'responsible_department',
        'status', 'assigned_to', 'resolved_at', 'resolution_notes',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'quantity_affected' => 'decimal:4',
        'resolved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (NonConformance $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (NonConformance $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function inspection()
    {
        return $this->belongsTo(QualityInspection::class, 'quality_inspection_id');
    }

    public function defectType()
    {
        return $this->belongsTo(DefectType::class, 'defect_type_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function correctiveActions()
    {
        return $this->hasMany(CorrectiveAction::class, 'non_conformance_id');
    }
}

