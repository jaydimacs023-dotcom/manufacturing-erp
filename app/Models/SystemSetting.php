<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'uuid',
        'key',
        'value',
        'group',
        'is_encrypted',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (SystemSetting $model) {
            $model->uuid = (string) Str::uuid();
            if (auth()->check() && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (SystemSetting $model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}

