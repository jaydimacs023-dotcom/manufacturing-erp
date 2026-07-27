<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;

class QualityChecklistItem extends Model
{
    protected $table = 'quality_checklist_items';

    protected $fillable = [
        'quality_checklist_id', 'item_name', 'specification', 'method',
        'expected_value', 'min_value', 'max_value', 'unit',
        'sort_order', 'is_required',
    ];

    protected $casts = [
        'min_value' => 'decimal:4',
        'max_value' => 'decimal:4',
        'is_required' => 'boolean',
    ];

    public function checklist()
    {
        return $this->belongsTo(QualityChecklist::class, 'quality_checklist_id');
    }
}

