<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('product_code', 50)->unique();
            $table->string('product_name', 255);
            $table->string('product_type', 50)->comment('raw_material, packaging, finished_good, consumable');
            $table->foreignId('category_id')->constrained('product_categories');
            $table->foreignId('default_uom_id')->constrained('units_of_measure');
            $table->text('description')->nullable();
            $table->integer('shelf_life_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('image_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

