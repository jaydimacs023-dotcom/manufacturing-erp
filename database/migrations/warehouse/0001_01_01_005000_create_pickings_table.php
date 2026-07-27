<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('picking_number', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('picking_type', 30); // production, shipment, transfer
            $table->string('status', 30)->default('pending'); // pending, in_progress, completed, cancelled
            $table->morphs('reference'); // manufacturing_order, sales_order, etc.
            $table->string('reference_number', 50)->nullable();
            $table->datetime('picking_date');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->datetime('completed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('picking_number');
            $table->index('status');
            $table->index('picking_type');
        });

        Schema::create('picking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('picking_id')->constrained('pickings')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('required_quantity', 15, 4);
            $table->decimal('picked_quantity', 15, 4)->default(0);
            $table->string('batch_number', 100)->nullable();
            $table->foreignId('storage_location_id')->nullable()->constrained('storage_locations')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('picking_items');
        Schema::dropIfExists('pickings');
    }
};

