<?php

namespace Modules\Inventory\Enums;

enum InventoryMovementType: string
{
    case Receive = 'receive';
    case Issue = 'issue';
    case TransferIn = 'transfer_in';
    case TransferOut = 'transfer_out';
    case AdjustmentPlus = 'adjustment_plus';
    case AdjustmentMinus = 'adjustment_minus';
    case ProductionIssue = 'production_issue';
    case ProductionReturn = 'production_return';
    case FinishedGoodsReceipt = 'finished_goods_receipt';
    case Shipment = 'shipment';
    case ReturnToSupplier = 'return_to_supplier';
}

