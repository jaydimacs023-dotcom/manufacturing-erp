<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_checklist_id')->constrained('quality_checklists')->cascadeOnDelete();
            $table->string('item_name', 100);
            $table->string('specification', 255)->nullable();
            $table->string('method', 100)->nullable();
            $table->string('expected_value', 255)->nullable();
            $table->decimal('min_value', 15, 4)->nullable();
            $table->decimal('max_value', 15, 4)->nullable();
            $table->string('unit', 30)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->index('quality_checklist_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_checklist_items');
    }
};

