<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('export_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('export_order_number')->unique();
            $table->foreignId('customer_id')->constrained('business_partners');
            $table->string('destination_country', 100);
            $table->string('port_of_loading', 100)->nullable();
            $table->string('port_of_destination', 100)->nullable();
            $table->string('vessel', 100)->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->string('container_number', 50)->nullable();
            $table->string('seal_number', 50)->nullable();
            $table->string('status', 50)->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_orders');
    }
};

