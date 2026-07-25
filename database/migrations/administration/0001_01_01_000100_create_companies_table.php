<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('company_name');
            $table->string('logo_path')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('tin')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('default_currency', 3)->default('USD');
            $table->string('timezone')->default('UTC');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

