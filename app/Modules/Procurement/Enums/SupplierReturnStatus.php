<?php

namespace Modules\Procurement\Enums;

enum SupplierReturnStatus: string
{
    case Draft = 'draft';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

