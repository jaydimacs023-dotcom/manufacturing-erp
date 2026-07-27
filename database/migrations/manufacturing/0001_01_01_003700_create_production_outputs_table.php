<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_outputs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('output_number', 50)->unique();
            $table->foreignId('manufacturing_order_id')->constrained('manufacturing_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('uom_id')->constrained('units_of_measure');
            $table->decimal('quantity_produced', 15, 4);
            $table->decimal('quantity_rejected', 15, 4)->default(0);
            $table->decimal('quantity_waste', 15, 4)->default(0);
            $table->string('batch_number', 100)->nullable();
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('status', 30)->default('pending_qc'); // pending_qc, approved, rejected
            $table->foreignId('inspected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('inspected_at')->nullable();
            $table->text('qc_remarks')->nullable();
            $table->decimal('yield_percentage', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('status');
            $table->index('batch_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_outputs');
    }
};
