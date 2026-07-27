<?php

namespace Modules\Procurement\Enums;

enum PurchaseRequestStatus: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case ConvertedToPo = 'converted_to_po';
    case Cancelled = 'cancelled';
}

