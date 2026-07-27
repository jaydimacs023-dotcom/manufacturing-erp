<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostingQueue extends Model
{
    protected $table = 'posting_queue';

    protected $fillable = [
        'uuid', 'queue_number', 'accounting_event_id', 'status',
        'retry_count', 'max_retries', 'error_message',
        'processed_at', 'processed_by',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'retry_count' => 'integer',
        'max_retries' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PostingQueue $model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function accountingEvent()
    {
        return $this->belongsTo(AccountingEvent::class);
    }

    public function processor()
    {
        return $this->belongsTo(\App\Models\User::class, 'processed_by');
    }
}
