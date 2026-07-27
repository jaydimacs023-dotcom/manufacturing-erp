<?php

namespace Modules\QualityControl\Enums;

enum QualityInspectionStatus: string
{
    case Draft = 'draft';
    case Passed = 'passed';
    case Conditional = 'conditional';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Passed => 'Passed',
            self::Conditional => 'Conditional Acceptance',
            self::Failed => 'Failed',
            self::Cancelled => 'Cancelled',
        };
    }
}

