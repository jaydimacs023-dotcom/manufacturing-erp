<?php

namespace Modules\Sales\Enums;

enum SalesOrderStatus: string
{
    case Draft = 'draft';
    case Confirmed = 'confirmed';
    case Allocated = 'allocated';
    case ReadyForShipment = 'ready_for_shipment';
    case Shipped = 'shipped';
    case Closed = 'closed';
    case Cancelled = 'cancelled';
}

