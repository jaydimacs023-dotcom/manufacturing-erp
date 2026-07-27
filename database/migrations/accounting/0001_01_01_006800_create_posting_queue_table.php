<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posting_queue', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('queue_number', 50)->unique();
            $table->foreignId('accounting_event_id')->constrained('accounting_events');
            $table->string('status', 30)->default('pending');
            $table->integer('retry_count')->default(0);
            $table->integer('max_retries')->default(3);
            $table->text('error_message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index('status');
            $table->index('accounting_event_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posting_queue');
    }
};
