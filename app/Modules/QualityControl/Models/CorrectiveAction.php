<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CorrectiveAction extends Model
{
    protected $table = 'corrective_actions';

    protected $fillable = [
        'uuid', 'action_number', 'quality_inspection_id', 'non_conformance_id',
        'action_type', 'status', 'description', 'action_taken',
        'responsible_person_id', 'due_date', 'completed_at', 'result_notes',
        'is_effective', 'approved_by', 'approved_at', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'approved_at' => 'datetime',
        'is_effective' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (CorrectiveAction $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (CorrectiveAction $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function inspection()
    {
        return $this->belongsTo(QualityInspection::class, 'quality_inspection_id');
    }

    public function nonConformance()
    {
        return $this->belongsTo(NonConformance::class, 'non_conformance_id');
    }

    public function responsiblePerson()
    {
        return $this->belongsTo(\App\Models\User::class, 'responsible_person_id');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}

