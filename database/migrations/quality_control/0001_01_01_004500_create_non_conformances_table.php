<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('non_conformances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nc_number', 50)->unique();
            $table->foreignId('quality_inspection_id')->constrained('quality_inspections');
            $table->foreignId('defect_type_id')->nullable()->constrained('defect_types')->nullOnDelete();
            $table->string('defect_type', 100);
            $table->string('severity', 20)->default('minor'); // minor, major, critical
            $table->decimal('quantity_affected', 15, 4)->default(0);
            $table->text('description');
            $table->string('root_cause', 500)->nullable();
            $table->string('recommended_action', 500)->nullable();
            $table->string('responsible_department', 100)->nullable();
            $table->string('status', 30)->default('open'); // open, in_progress, resolved, closed
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('nc_number');
            $table->index('status');
            $table->index('severity');
            $table->index('quality_inspection_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('non_conformances');
    }
};

