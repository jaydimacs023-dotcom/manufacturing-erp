<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_partners', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('partner_code', 50)->unique();
            $table->string('partner_name', 255);
            $table->string('partner_type', 50)->comment('supplier, customer, freight_forwarder, customs_broker, service_provider');
            $table->string('tax_identification_number', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->foreignId('payment_term_id')->nullable()->constrained('payment_terms')->nullOnDelete();
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_partners');
    }
};

