<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('waste_number', 50)->unique();
            $table->foreignId('manufacturing_order_id')->constrained('manufacturing_orders')->cascadeOnDelete();
            $table->foreignId('production_output_id')->nullable()->constrained('production_outputs')->nullOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('uom_id')->constrained('units_of_measure');
            $table->string('waste_type', 50); // banana_peel, burnt_chips, oil_loss, rejected_product, packaging_damage, other
            $table->decimal('quantity', 15, 4);
            $table->string('reason', 255);
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('waste_type');
            $table->index('manufacturing_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_records');
    }
};
