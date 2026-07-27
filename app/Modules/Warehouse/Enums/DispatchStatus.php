<?php

namespace Modules\Warehouse\Enums;

enum DispatchStatus: string
{
    case Draft = 'draft';
    case Packed = 'packed';
    case Loaded = 'loaded';
    case Dispatched = 'dispatched';
    case Cancelled = 'cancelled';
}

