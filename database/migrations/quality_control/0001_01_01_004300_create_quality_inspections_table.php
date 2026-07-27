<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_inspections', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('inspection_number', 50)->unique();
            $table->string('inspection_type', 30); // incoming, in_process, final
            $table->string('status', 30)->default('draft'); // draft, passed, conditional, failed, cancelled
            $table->foreignId('inspection_type_id')->nullable()->constrained('inspection_types')->nullOnDelete();
            $table->foreignId('quality_checklist_id')->nullable()->constrained('quality_checklists')->nullOnDelete();

            // Reference to source document (goods_receipt, manufacturing_order, etc.)
            $table->string('inspection_source_type', 50)->nullable();
            $table->unsignedBigInteger('inspection_source_id')->nullable();
            $table->index(['inspection_source_type', 'inspection_source_id'], 'qc_inspection_source_idx');

            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity_inspected', 15, 4)->default(0);
            $table->decimal('quantity_passed', 15, 4)->default(0);
            $table->decimal('quantity_failed', 15, 4)->default(0);
            $table->string('batch_number', 50)->nullable();
            $table->string('lot_number', 50)->nullable();
            $table->foreignId('inspector_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('inspection_date');
            $table->dateTime('completed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('inspection_number');
            $table->index('status');
            $table->index('inspection_type');
            $table->index('batch_number');
            $table->index('inspection_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_inspections');
    }
};

