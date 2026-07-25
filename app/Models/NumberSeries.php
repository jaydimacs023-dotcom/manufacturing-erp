<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NumberSeries extends Model
{
    protected $table = 'number_series';

    protected $fillable = [
        'uuid',
        'document_type',
        'prefix',
        'branch_id',
        'current_year',
        'current_sequence',
        'pad_length',
        'suffix',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'current_year' => 'integer',
        'current_sequence' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (NumberSeries $model) {
            $model->uuid = (string) Str::uuid();
            if (auth()->check() && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (NumberSeries $model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}

