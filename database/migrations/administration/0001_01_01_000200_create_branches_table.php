<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('branch_code')->unique();
            $table->string('branch_name');
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

