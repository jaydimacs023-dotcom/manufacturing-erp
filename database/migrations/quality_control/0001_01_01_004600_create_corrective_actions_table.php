<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('action_number', 50)->unique();
            $table->foreignId('quality_inspection_id')->constrained('quality_inspections');
            $table->foreignId('non_conformance_id')->nullable()->constrained('non_conformances')->nullOnDelete();
            $table->string('action_type', 30); // rework, re_inspection, disposal, supplier_return
            $table->string('status', 30)->default('open'); // open, in_progress, completed, closed
            $table->text('description');
            $table->text('action_taken')->nullable();
            $table->foreignId('responsible_person_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->text('result_notes')->nullable();
            $table->boolean('is_effective')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('action_number');
            $table->index('status');
            $table->index('action_type');
            $table->index('quality_inspection_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corrective_actions');
    }
};

