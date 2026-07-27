<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_inspection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_inspection_id')->constrained('quality_inspections')->cascadeOnDelete();
            $table->foreignId('checklist_item_id')->nullable()->constrained('quality_checklist_items')->nullOnDelete();
            $table->string('item_name', 100);
            $table->string('specification', 255)->nullable();
            $table->string('method', 100)->nullable();
            $table->string('expected_value', 255)->nullable();
            $table->decimal('min_value', 15, 4)->nullable();
            $table->decimal('max_value', 15, 4)->nullable();
            $table->string('unit', 30)->nullable();
            $table->decimal('actual_value', 15, 4)->nullable();
            $table->string('result', 30)->nullable(); // pass, fail, conditional
            $table->text('remarks')->nullable();
            $table->integer('sort_order')->default(0);

            $table->index('quality_inspection_id');
            $table->index('result');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_inspection_items');
    }
};

