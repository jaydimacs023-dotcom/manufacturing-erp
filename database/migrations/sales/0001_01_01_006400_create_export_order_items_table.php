<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('export_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('export_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('sales_order_id')->constrained();
            $table->foreignId('sales_order_item_id')->constrained('sales_order_items');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('quantity', 12, 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_order_items');
    }
};

