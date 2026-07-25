<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique();
            $table->unsignedBigInteger('branch_id')->nullable()->after('remember_token');
            $table->unsignedBigInteger('department_id')->nullable()->after('branch_id');
            $table->boolean('is_active')->default(true)->after('department_id');
            $table->boolean('is_locked')->default(false)->after('is_active');
            $table->timestamp('last_login_at')->nullable()->after('is_locked');
            $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at');

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn([
                'uuid', 'branch_id', 'department_id', 'is_active', 'is_locked',
                'last_login_at', 'created_by', 'updated_by', 'deleted_at', 'deleted_by'
            ]);
        });
    }
};

