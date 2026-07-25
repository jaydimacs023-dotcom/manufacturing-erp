<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'uuid',
        'company_name',
        'logo_path',
        'address',
        'contact_email',
        'contact_phone',
        'tin',
        'registration_number',
        'default_currency',
        'timezone',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Company $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Company $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}

