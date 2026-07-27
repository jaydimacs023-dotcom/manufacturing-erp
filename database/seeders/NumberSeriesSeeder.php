<?php

namespace Database\Seeders;

use App\Models\NumberSeries;
use Illuminate\Database\Seeder;

class NumberSeriesSeeder extends Seeder
{
    public function run(): void
    {
        $series = [
            // Procurement
            ['document_type' => 'PurchaseRequest', 'prefix' => 'PR', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'PurchaseOrder', 'prefix' => 'PO', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'GoodsReceipt', 'prefix' => 'GR', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'SupplierReturn', 'prefix' => 'SR', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],

            // Inventory
            ['document_type' => 'InventoryMovement', 'prefix' => 'IM', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'InventoryAdjustment', 'prefix' => 'IA', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'StockTransfer', 'prefix' => 'ST', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],

            // Manufacturing
            ['document_type' => 'BillOfMaterials', 'prefix' => 'BOM', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'ManufacturingOrder', 'prefix' => 'MO', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'MaterialReturn', 'prefix' => 'MR', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'WasteRecord', 'prefix' => 'WO', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],

            // Quality Control
            ['document_type' => 'IncomingQualityInspection', 'prefix' => 'IQC', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'ProcessQualityInspection', 'prefix' => 'PQC', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'FinishedGoodsInspection', 'prefix' => 'FQC', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'CorrectiveActionReport', 'prefix' => 'CAR', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],

            // Warehouse
            ['document_type' => 'Putaway', 'prefix' => 'PT', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'Picking', 'prefix' => 'PK', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'PackingSlip', 'prefix' => 'PS', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'Dispatch', 'prefix' => 'DSP', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],

            // Sales & Export
            ['document_type' => 'Quotation', 'prefix' => 'QT', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'SalesOrder', 'prefix' => 'SO', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'ExportOrder', 'prefix' => 'EO', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'PackingList', 'prefix' => 'PL', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
            ['document_type' => 'CommercialInvoice', 'prefix' => 'CI', 'current_year' => date('Y'), 'current_sequence' => 0, 'pad_length' => 6],
        ];

        foreach ($series as $item) {
            NumberSeries::firstOrCreate(
                ['document_type' => $item['document_type']],
                $item
            );
        }
    }
}
