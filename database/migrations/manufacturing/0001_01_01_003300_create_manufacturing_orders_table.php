<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manufacturing_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('mo_number', 50)->unique();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('bill_of_material_id')->constrained('bill_of_materials');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->decimal('planned_quantity', 15, 4);
            $table->decimal('produced_quantity', 15, 4)->default(0);
            $table->decimal('rejected_quantity', 15, 4)->default(0);
            $table->decimal('waste_quantity', 15, 4)->default(0);
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            $table->dateTime('actual_start_date')->nullable();
            $table->dateTime('actual_end_date')->nullable();
            $table->string('status', 30)->default('draft');
            $table->string('priority', 20)->default('normal'); // low, normal, high, urgent
            $table->foreignId('production_supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('mo_number');
            $table->index('planned_start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturing_orders');
    }
};

