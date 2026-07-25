<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Modules\Administration\Models\Branch;
use Modules\Administration\Models\Department;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'branch_id',
        'department_id',
        'is_active',
        'is_locked',
        'last_login_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (User $model) {
            $model->uuid = (string) Str::uuid();
            if (auth()->check() && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (User $model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

