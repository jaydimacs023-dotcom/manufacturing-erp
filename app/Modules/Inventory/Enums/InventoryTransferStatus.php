<?php

namespace Modules\Inventory\Enums;

enum InventoryTransferStatus: string
{
    case Draft = 'draft';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

