<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('mapping_type', 50);
            $table->string('source_type', 50);
            $table->string('account_code', 50);
            $table->string('account_name', 200);
            $table->string('direction', 10); // debit, credit
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index('mapping_type');
            $table->index('source_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_mappings');
    }
};
