<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'uuid',
        'user_id',
        'action',
        'module',
        'document_number',
        'old_values',
        'new_values',
        'remarks',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (AuditLog $model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

