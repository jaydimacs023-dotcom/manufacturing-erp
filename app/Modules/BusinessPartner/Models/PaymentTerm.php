<?php

namespace Modules\BusinessPartner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PaymentTerm extends Model
{
    use SoftDeletes;

    protected $table = 'payment_terms';

    protected $fillable = [
        'uuid',
        'term_code',
        'term_name',
        'description',
        'due_days',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'due_days' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PaymentTerm $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (PaymentTerm $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function businessPartners()
    {
        return $this->hasMany(BusinessPartner::class, 'payment_term_id');
    }
}

