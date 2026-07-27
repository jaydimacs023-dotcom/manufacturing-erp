<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('reference_type', 50); // manufacturing_order, sales_order
            $table->unsignedBigInteger('reference_id');
            $table->decimal('quantity_reserved', 15, 4);
            $table->decimal('quantity_consumed', 15, 4)->default(0);
            $table->string('batch_number', 100)->nullable();
            $table->string('status', 30)->default('active'); // active, consumed, cancelled
            $table->date('reserved_until')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('product_id');
            $table->index('warehouse_id');
            $table->index(['reference_type', 'reference_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_reservations');
    }
};

