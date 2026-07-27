<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type', 50);
            $table->string('debit_account_code', 50)->nullable();
            $table->string('debit_account_name', 200)->nullable();
            $table->string('credit_account_code', 50)->nullable();
            $table->string('credit_account_name', 200)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('transaction_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_mappings');
    }
};
