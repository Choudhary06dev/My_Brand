<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'blogs',
            'certificates',
            'clients',
            'company_info',
            'contact_messages',
            'email_templates',
            'job_applications',
            'job_openings',
            'news',
            'products',
            'product_categories',
            'product_galleries',
            'roles',
            'permissions',
            'services',
            'sliders'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'deleted_at')) {
                        $table->softDeletes();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'blogs',
            'certificates',
            'clients',
            'company_info',
            'contact_messages',
            'email_templates',
            'job_applications',
            'job_openings',
            'news',
            'products',
            'product_categories',
            'product_galleries',
            'roles',
            'permissions',
            'services',
            'sliders'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'deleted_at')) {
                        $table->dropSoftDeletes();
                    }
                });
            }
        }
    }
};
