<?php

namespace Modules\QualityControl\Enums;

enum QualityInspectionType: string
{
    case Incoming = 'incoming';
    case InProcess = 'in_process';
    case Final = 'final';

    public function label(): string
    {
        return match ($this) {
            self::Incoming => 'Incoming Quality Inspection',
            self::InProcess => 'In-Process Quality Inspection',
            self::Final => 'Finished Goods Inspection',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::Incoming => 'Incoming QC',
            self::InProcess => 'In-Process QC',
            self::Final => 'Final QC',
        };
    }
}

