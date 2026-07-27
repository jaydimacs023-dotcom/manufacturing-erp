<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('transfer_number', 50)->unique();
            $table->foreignId('source_warehouse_id')->constrained('warehouses');
            $table->foreignId('source_location_id')->constrained('storage_locations');
            $table->foreignId('destination_warehouse_id')->constrained('warehouses');
            $table->foreignId('destination_location_id')->constrained('storage_locations');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity', 15, 4);
            $table->string('batch_number', 100)->nullable();
            $table->string('status', 30)->default('draft'); // draft, approved, completed, cancelled
            $table->string('reason', 255)->nullable();
            $table->datetime('transfer_date')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->datetime('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('transfer_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_transfers');
    }
};

