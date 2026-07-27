<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('goods_receipt_number', 50)->unique();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders');
            $table->string('delivery_receipt_number', 100)->nullable();
            $table->string('supplier_invoice_number', 100)->nullable();
            $table->date('date_received');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('received_by', 255);
            $table->string('status', 30)->default('draft');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('goods_receipt_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};

