<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalMapping extends Model
{
    use SoftDeletes;

    protected $table = 'journal_mappings';

    protected $fillable = [
        'transaction_type', 'debit_account_code', 'debit_account_name',
        'credit_account_code', 'credit_account_name', 'description',
        'is_active', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
