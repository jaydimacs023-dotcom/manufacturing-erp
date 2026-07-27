<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('event_number', 50)->unique();
            $table->string('transaction_type', 50);
            $table->string('transaction_number', 50);
            $table->foreignId('transaction_id')->nullable();
            $table->string('source_module', 50);
            $table->date('posting_date');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->string('currency', 3)->default('IDR');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('status', 30)->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('posted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_type');
            $table->index('transaction_number');
            $table->index('status');
            $table->index('source_module');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_events');
    }
};
