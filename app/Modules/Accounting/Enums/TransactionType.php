<?php

namespace Modules\Accounting\Enums;

enum TransactionType: string
{
    case GoodsReceipt = 'goods_receipt';
    case SupplierReturn = 'supplier_return';
    case MaterialIssue = 'material_issue';
    case FinishedGoodsReceipt = 'finished_goods_receipt';
    case InventoryAdjustment = 'inventory_adjustment';
    case Shipment = 'shipment';
    case SalesInvoice = 'sales_invoice';
    case CreditMemo = 'credit_memo';
    case DebitMemo = 'debit_memo';

    public function label(): string
    {
        return match ($this) {
            self::GoodsReceipt => 'Goods Receipt',
            self::SupplierReturn => 'Supplier Return',
            self::MaterialIssue => 'Material Issue',
            self::FinishedGoodsReceipt => 'Finished Goods Receipt',
            self::InventoryAdjustment => 'Inventory Adjustment',
            self::Shipment => 'Shipment',
            self::SalesInvoice => 'Sales Invoice',
            self::CreditMemo => 'Credit Memo',
            self::DebitMemo => 'Debit Memo',
        };
    }
}
