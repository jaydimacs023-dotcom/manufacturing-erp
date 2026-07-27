<?php

namespace Modules\Manufacturing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MaterialIssueItem extends Model
{
    protected $table = 'material_issue_items';

    protected $fillable = [
        'uuid',
        'material_issue_id',
        'product_id',
        'uom_id',
        'quantity_issued',
        'unit_cost',
        'total_cost',
        'batch_number',
        'remarks',
    ];

    protected $casts = [
        'quantity_issued' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'total_cost' => 'decimal:4',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (MaterialIssueItem $model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function materialIssue()
    {
        return $this->belongsTo(MaterialIssue::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\Product::class);
    }

    public function uom()
    {
        return $this->belongsTo(\Modules\ProductMaster\Models\UnitOfMeasure::class, 'uom_id');
    }
}
