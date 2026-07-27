<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountMapping extends Model
{
    use SoftDeletes;

    protected $table = 'account_mappings';

    protected $fillable = [
        'mapping_type', 'source_type', 'account_code', 'account_name',
        'direction', 'description', 'is_active', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
