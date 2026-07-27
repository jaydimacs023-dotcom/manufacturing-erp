<?php

namespace Modules\Sales\Enums;

enum ShipmentStatus: string
{
    case Planned = 'planned';
    case Ready = 'ready';
    case Loaded = 'loaded';
    case Dispatched = 'dispatched';
    case InTransit = 'in_transit';
    case Delivered = 'delivered';
}

