<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_issues', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('issue_number', 50)->unique();
            $table->foreignId('manufacturing_order_id')->constrained('manufacturing_orders');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->date('issue_date');
            $table->string('status', 30)->default('draft'); // draft, completed, cancelled
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('issue_number');
            $table->index('manufacturing_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_issues');
    }
};

