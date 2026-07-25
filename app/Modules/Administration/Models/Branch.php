<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'uuid',
        'branch_code',
        'branch_name',
        'address',
        'contact_number',
        'is_active',
        'company_id',
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
        static::creating(function (Branch $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (Branch $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

