<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SidebarPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',
            'users',
            'roles',
            'company_info',
            'team_members',
            'services',
            'products',
            'product_categories',
            'product_gallery',
            'blogs',
            'sliders',
            'contact_messages',
            'job_openings',
            'job_applications',
            'email_templates',
            'activity_logs',
            'error_logs',
            'visitors',
            'clients',
            'certificates',
            'settings'
        ];

        foreach ($permissions as $permission) {
            \Illuminate\Support\Facades\DB::table('permissions')->updateOrInsert(
                ['permission_key' => $permission],
                ['description' => ucfirst($permission) . ' permission', 'created_at' => now(), 'updated_at' => now()]
            );

            \Illuminate\Support\Facades\DB::table('role_permissions')->updateOrInsert(
                ['role_id' => 1, 'permission_name' => $permission]
            );
        }
    }
}
