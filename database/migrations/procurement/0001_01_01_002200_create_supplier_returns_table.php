<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_returns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('supplier_return_number', 50)->unique();
            $table->foreignId('goods_receipt_id')->constrained('goods_receipts');
            $table->date('return_date');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('reason', 255);
            $table->string('status', 30)->default('draft');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('supplier_return_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_returns');
    }
};

