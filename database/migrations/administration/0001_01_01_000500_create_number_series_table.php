<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('number_series', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('document_type');
            $table->string('prefix');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->integer('current_year');
            $table->unsignedBigInteger('current_sequence')->default(0);
            $table->integer('pad_length')->default(6);
            $table->string('suffix')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->unique(['document_type', 'branch_id', 'current_year']);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('number_series');
    }
};

