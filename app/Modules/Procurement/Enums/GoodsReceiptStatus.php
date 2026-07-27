<?php

namespace Modules\Procurement\Enums;

enum GoodsReceiptStatus: string
{
    case Draft = 'draft';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

