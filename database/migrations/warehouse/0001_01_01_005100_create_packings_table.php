<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('packing_number', 50)->unique();
            $table->string('packing_type', 30); // shipment, transfer
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->morphs('reference'); // dispatch, warehouse_transfer
            $table->string('reference_number', 50)->nullable();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity', 15, 4);
            $table->integer('carton_count')->nullable();
            $table->decimal('gross_weight', 15, 4)->nullable();
            $table->decimal('net_weight', 15, 4)->nullable();
            $table->string('weight_uom', 20)->nullable();
            $table->string('status', 30)->default('pending'); // pending, completed
            $table->datetime('packing_date');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('packing_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};

