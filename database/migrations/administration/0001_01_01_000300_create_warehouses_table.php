<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('warehouse_code')->unique();
            $table->string('warehouse_name');
            $table->string('warehouse_type')->default('raw_material');
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};

