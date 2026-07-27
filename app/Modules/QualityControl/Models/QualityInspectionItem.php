<?php

namespace Modules\QualityControl\Models;

use Illuminate\Database\Eloquent\Model;

class QualityInspectionItem extends Model
{
    protected $table = 'quality_inspection_items';

    protected $fillable = [
        'quality_inspection_id', 'checklist_item_id', 'item_name', 'specification',
        'method', 'expected_value', 'min_value', 'max_value', 'unit',
        'actual_value', 'result', 'remarks', 'sort_order',
    ];

    protected $casts = [
        'min_value' => 'decimal:4',
        'max_value' => 'decimal:4',
        'actual_value' => 'decimal:4',
    ];

    public function inspection()
    {
        return $this->belongsTo(QualityInspection::class, 'quality_inspection_id');
    }

    public function checklistItem()
    {
        return $this->belongsTo(QualityChecklistItem::class, 'checklist_item_id');
    }
}

