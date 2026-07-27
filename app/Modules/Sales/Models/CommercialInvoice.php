<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CommercialInvoice extends Model
{
    use SoftDeletes;

    protected $table = 'commercial_invoices';

    protected $fillable = [
        'uuid', 'invoice_number', 'export_order_id',
        'customer_id', 'total_amount', 'currency',
        'notes', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (CommercialInvoice $model) {
            $model->uuid = (string) Str::uuid();
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
        static::updating(function (CommercialInvoice $model) {
            $model->updated_by = auth()->id();
        });
    }

    public function exportOrder()
    {
        return $this->belongsTo(ExportOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(\Modules\BusinessPartner\Models\BusinessPartner::class, 'customer_id');
    }
}

