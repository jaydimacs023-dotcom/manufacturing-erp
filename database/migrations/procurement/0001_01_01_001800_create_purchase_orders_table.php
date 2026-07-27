<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('purchase_order_number', 50)->unique();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests');
            $table->foreignId('supplier_id')->constrained('business_partners');
            $table->text('delivery_address')->nullable();
            $table->date('expected_delivery_date');
            $table->foreignId('payment_term_id')->nullable()->constrained('payment_terms')->nullOnDelete();
            $table->string('currency', 3)->default('PHP');
            $table->string('status', 30)->default('draft');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('purchase_order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};

