<?php

namespace Modules\BusinessPartner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ContactPerson extends Model
{
    use SoftDeletes;

    protected $table = 'contact_persons';

    protected $fillable = [
        'uuid',
        'business_partner_id',
        'name',
        'position',
        'mobile',
        'email',
        'is_primary',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (ContactPerson $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (ContactPerson $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function businessPartner()
    {
        return $this->belongsTo(BusinessPartner::class);
    }
}

