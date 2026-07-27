<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('putaways', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('putaway_number', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->foreignId('storage_location_id')->constrained('storage_locations');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity', 15, 4);
            $table->string('batch_number', 100)->nullable();
            $table->morphs('source'); // goods_receipt, production_output, etc.
            $table->string('reference_type', 50)->nullable();
            $table->string('reference_number', 50)->nullable();
            $table->string('status', 30)->default('pending'); // pending, completed, cancelled
            $table->datetime('putaway_date');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('putaway_number');
            $table->index('status');
            $table->index('batch_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('putaways');
    }
};

