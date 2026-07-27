<?php

namespace Modules\Accounting\Enums;

enum AccountingEventStatus: string
{
    case Pending = 'pending';
    case Posted = 'posted';
    case Failed = 'failed';
    case Cancelled = 'cancelled';
    case Reposted = 'reposted';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Posted => 'Posted',
            self::Failed => 'Failed',
            self::Cancelled => 'Cancelled',
            self::Reposted => 'Reposted',
        };
    }
}
