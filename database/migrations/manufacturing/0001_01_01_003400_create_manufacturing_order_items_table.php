<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manufacturing_order_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('manufacturing_order_id')->constrained('manufacturing_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('uom_id')->constrained('units_of_measure');
            $table->decimal('planned_quantity', 15, 4);
            $table->decimal('issued_quantity', 15, 4)->default(0);
            $table->decimal('consumed_quantity', 15, 4)->default(0);
            $table->decimal('returned_quantity', 15, 4)->default(0);
            $table->decimal('unit_cost', 15, 4)->default(0);
            $table->decimal('total_cost', 15, 4)->default(0);
            $table->string('item_type', 50)->default('raw_material');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('manufacturing_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturing_order_items');
    }
};

