<?php

namespace Modules\Manufacturing\Enums;

enum ManufacturingOrderStatus: string
{
    case Draft = 'draft';
    case Planned = 'planned';
    case Released = 'released';
    case InProgress = 'in_progress';
    case QualityInspection = 'quality_inspection';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

