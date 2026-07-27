<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_of_materials', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('bom_number', 50)->unique();
            $table->foreignId('product_id')->constrained('products');
            $table->string('version', 20)->default('1.0');
            $table->date('effective_date');
            $table->string('status', 30)->default('draft'); // draft, active, inactive, archived
            $table->text('description')->nullable();
            $table->decimal('total_quantity', 15, 4)->default(1);
            $table->decimal('total_cost', 15, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('bom_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_of_materials');
    }
};

