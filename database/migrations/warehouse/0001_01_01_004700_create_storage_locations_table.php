<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storage_locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('location_code', 50);
            $table->string('storage_area', 100)->nullable();
            $table->string('rack', 50)->nullable();
            $table->string('bin', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->decimal('max_capacity', 15, 4)->nullable();
            $table->string('uom_code', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['warehouse_id', 'location_code']);
            $table->index('storage_area');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storage_locations');
    }
};

