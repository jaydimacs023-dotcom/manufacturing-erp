<?php

namespace Modules\Warehouse\Enums;

enum WarehouseTransferStatus: string
{
    case Draft = 'draft';
    case Approved = 'approved';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

