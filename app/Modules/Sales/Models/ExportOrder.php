<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ExportOrder extends Model
{
    use SoftDeletes;

    protected $table = 'export_orders';

    protected $fillable = [
        'uuid', 'export_order_number', 'customer_id',
        'destination_country', 'port_of_loading', 'port_of_destination',
        'vessel', 'etd', 'eta',
        'container_number', 'seal_number',
        'status', 'notes',
        'approved_by', 'approved_at',
        'shipped_at', 'delivered_at',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'etd' => 'date',
        'eta' => 'date',
        'approved_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (ExportOrder $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (ExportOrder $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function items()
    {
        return $this->hasMany(ExportOrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(\Modules\BusinessPartner\Models\BusinessPartner::class, 'customer_id');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function packingLists()
    {
        return $this->hasMany(PackingList::class);
    }

    public function commercialInvoices()
    {
        return $this->hasMany(CommercialInvoice::class);
    }
}

