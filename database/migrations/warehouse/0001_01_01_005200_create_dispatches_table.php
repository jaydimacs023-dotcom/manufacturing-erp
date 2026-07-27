<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('dispatch_number', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('dispatch_type', 30); // sales, export, transfer
            $table->string('status', 30)->default('draft'); // draft, packed, loaded, dispatched, cancelled
            $table->morphs('reference'); // sales_order, export_order, warehouse_transfer
            $table->string('reference_number', 50)->nullable();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity', 15, 4);
            $table->string('batch_number', 100)->nullable();
            $table->string('destination', 255)->nullable();
            $table->string('vehicle_number', 50)->nullable();
            $table->string('container_number', 50)->nullable();
            $table->string('seal_number', 50)->nullable();
            $table->datetime('dispatch_date')->nullable();
            $table->datetime('loaded_at')->nullable();
            $table->datetime('dispatched_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->datetime('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('dispatch_number');
            $table->index('status');
            $table->index('dispatch_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatches');
    }
};

