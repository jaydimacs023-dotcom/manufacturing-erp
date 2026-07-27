<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseRequest extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_requests';

    protected $fillable = [
        'uuid',
        'request_number',
        'request_date',
        'department_id',
        'required_date',
        'priority',
        'requested_by',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'request_date' => 'date',
        'required_date' => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (PurchaseRequest $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (PurchaseRequest $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function department()
    {
        return $this->belongsTo(\Modules\Administration\Models\Department::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}

