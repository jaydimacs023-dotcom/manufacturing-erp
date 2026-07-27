<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packing_lists', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('packing_list_number')->unique();
            $table->foreignId('export_order_id')->constrained();
            $table->foreignId('product_id')->constrained('products');
            $table->string('batch_number', 100)->nullable();
            $table->decimal('quantity', 12, 4);
            $table->integer('number_of_cartons')->nullable();
            $table->decimal('net_weight', 10, 2)->nullable();
            $table->decimal('gross_weight', 10, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packing_lists');
    }
};

