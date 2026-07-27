<?php

namespace Modules\Sales\Enums;

enum ExportOrderStatus: string
{
    case Draft = 'draft';
    case Planned = 'planned';
    case Loaded = 'loaded';
    case Dispatched = 'dispatched';
    case InTransit = 'in_transit';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}

