<?php

namespace App\Services;

use App\Models\NumberSeries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NumberSeriesService
{
    /**
     * Generate the next document number for a given document type.
     *
     * Uses database-level locking to prevent race conditions.
     *
     * Format: PREFIX-YEAR-SEQUENCE
     * Example: PO-2026-000001
     */
    public function generateNext(string $documentType, ?string $prefix = null, ?int $branchId = null): string
    {
        return DB::transaction(function () use ($documentType, $prefix, $branchId) {
            // Lock the number series row for update
            $series = NumberSeries::where('document_type', $documentType)
                ->where('branch_id', $branchId)
                ->lockForUpdate()
                ->first();

            if (!$series) {
                $series = $this->createDefaultSeries($documentType, $prefix, $branchId);
            }

            $year = now()->year;
            $currentYear = $series->current_year;

            // Reset sequence if year changed
            if ($currentYear !== $year) {
                $series->current_sequence = 0;
                $series->current_year = $year;
            }

            // Increment sequence
            $series->current_sequence++;
            $sequence = $series->current_sequence;

            // Save updated sequence
            $series->save();

            $prefix = $series->prefix;
            $padLength = $series->pad_length ?? 6;

            return sprintf('%s-%d-%s', $prefix, $year, str_pad($sequence, $padLength, '0', STR_PAD_LEFT));
        });
    }

    /**
     * Generate next batch number.
     *
     * Format: BATCH-YYYYMMDD-XXXX
     */
    public function generateBatchNumber(): string
    {
        return DB::transaction(function () {
            $date = now()->format('Ymd');
            $key = 'BATCH_' . $date;

            $series = NumberSeries::where('document_type', 'BATCH')
                ->where('prefix', 'BATCH')
                ->lockForUpdate()
                ->first();

            if (!$series) {
                $series = NumberSeries::create([
                    'document_type' => 'BATCH',
                    'prefix' => 'BATCH',
                    'current_year' => now()->year,
                    'current_sequence' => 0,
                    'pad_length' => 4,
                    'is_active' => true,
                ]);
            }

            $series->current_sequence++;
            $sequence = $series->current_sequence;
            $series->save();

            return sprintf('BATCH-%s-%s', $date, str_pad($sequence, 4, '0', STR_PAD_LEFT));
        });
    }

    /**
     * Create a default number series configuration.
     */
    private function createDefaultSeries(string $documentType, ?string $prefix, ?int $branchId): NumberSeries
    {
        $prefix = $prefix ?? $this->getDefaultPrefix($documentType);

        return NumberSeries::create([
            'document_type' => $documentType,
            'prefix' => $prefix,
            'branch_id' => $branchId,
            'current_year' => now()->year,
            'current_sequence' => 0,
            'pad_length' => 6,
            'is_active' => true,
        ]);
    }

    /**
     * Get default prefix for a document type.
     */
    public function getDefaultPrefix(string $documentType): string
    {
        $prefixes = [
            'USER' => 'USR',
            'ROLE' => 'ROL',
            'BRANCH' => 'BR',
            'WAREHOUSE' => 'WH',
            'PRODUCT' => 'PRD',
            'CATEGORY' => 'CAT',
            'UOM' => 'UOM',
            'SUPPLIER' => 'SUP',
            'CUSTOMER' => 'CUS',
            'PURCHASE_REQUEST' => 'PR',
            'PURCHASE_ORDER' => 'PO',
            'GOODS_RECEIPT' => 'GR',
            'SUPPLIER_RETURN' => 'SR',
            'INVENTORY_MOVEMENT' => 'IM',
            'INVENTORY_ADJUSTMENT' => 'IA',
            'STOCK_TRANSFER' => 'ST',
            'BILL_OF_MATERIALS' => 'BOM',
            'MANUFACTURING_ORDER' => 'MO',
            'MATERIAL_RETURN' => 'MR',
            'WASTE_RECORD' => 'WO',
            'INCOMING_QC' => 'IQC',
            'PROCESS_QC' => 'PQC',
            'FINISHED_QC' => 'FQC',
            'CORRECTIVE_ACTION' => 'CAR',
            'PUTAWAY' => 'PT',
            'PICKING' => 'PK',
            'PACKING_SLIP' => 'PS',
            'DISPATCH' => 'DSP',
            'QUOTATION' => 'QT',
            'SALES_ORDER' => 'SO',
            'EXPORT_ORDER' => 'EO',
            'PACKING_LIST' => 'PL',
            'COMMERCIAL_INVOICE' => 'CI',
            'ACCOUNTING_EVENT' => 'AE',
            'JOURNAL_ENTRY' => 'JE',
            'REPORT' => 'RPT',
        ];

        return $prefixes[$documentType] ?? 'DOC';
    }

    /**
     * Peek at the next number without incrementing.
     */
    public function previewNext(string $documentType, ?int $branchId = null): string
    {
        $series = NumberSeries::where('document_type', $documentType)
            ->where('branch_id', $branchId)
            ->first();

        if (!$series) {
            $prefix = $this->getDefaultPrefix($documentType);
            return sprintf('%s-%d-%s', $prefix, now()->year, '000001');
        }

        $year = now()->year;
        $currentYear = $series->current_year;
        $nextSequence = ($currentYear === $year) ? $series->current_sequence + 1 : 1;
        $prefix = $series->prefix;
        $padLength = $series->pad_length ?? 6;

        return sprintf('%s-%d-%s', $prefix, $year, str_pad($nextSequence, $padLength, '0', STR_PAD_LEFT));
    }
}

