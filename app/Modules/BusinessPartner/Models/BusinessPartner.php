<?php

namespace Modules\BusinessPartner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BusinessPartner extends Model
{
    use SoftDeletes;

    protected $table = 'business_partners';

    protected $fillable = [
        'uuid',
        'partner_code',
        'partner_name',
        'partner_type',
        'tax_identification_number',
        'address',
        'country',
        'phone',
        'email',
        'website',
        'payment_term_id',
        'credit_limit',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_limit' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (BusinessPartner $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (BusinessPartner $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_term_id');
    }

    public function contactPersons()
    {
        return $this->hasMany(ContactPerson::class);
    }
}

