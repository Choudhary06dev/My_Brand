<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        DB::table('role_permissions')->delete();
        DB::table('permissions')->delete();
        DB::table('users')->where('email', 'admin@example.com')->delete();
        DB::table('roles')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create permissions
        $permissions = [
            ['permission_key' => 'dashboard', 'description' => 'Access to Dashboard'],
            ['permission_key' => 'users', 'description' => 'Access to Users Management'],
            ['permission_key' => 'roles', 'description' => 'Access to Roles Management'],
            ['permission_key' => 'company_info', 'description' => 'Access to Company Info'],
            ['permission_key' => 'services', 'description' => 'Access to Services'],
            ['permission_key' => 'product_categories', 'description' => 'Access to Product Categories'],
            ['permission_key' => 'products', 'description' => 'Access to Products'],
            ['permission_key' => 'blogs', 'description' => 'Access to Blogs'],
            ['permission_key' => 'sliders', 'description' => 'Access to Sliders'],
            ['permission_key' => 'job_openings', 'description' => 'Access to Job Openings'],
            ['permission_key' => 'job_applications', 'description' => 'Access to Job Applications'],
            ['permission_key' => 'email_templates', 'description' => 'Access to Email Templates'],
            ['permission_key' => 'contact_messages', 'description' => 'Access to Contact Messages'],
            ['permission_key' => 'activity_logs', 'description' => 'Access to Activity Logs'],
            ['permission_key' => 'error_logs', 'description' => 'Access to Error Logs'],
            ['permission_key' => 'visitors', 'description' => 'Access to Visitors'],
            ['permission_key' => 'clients', 'description' => 'Access to Clients'],
            ['permission_key' => 'certificates', 'description' => 'Access to Certificates'],
            ['permission_key' => 'product_gallery', 'description' => 'Access to Product Gallery'],
            ['permission_key' => 'settings', 'description' => 'Access to Settings']
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'permission_key' => $permission['permission_key'],
                'description' => $permission['description'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create Admin Role
        $adminRoleId = DB::table('roles')->insertGetId([
            'role_name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Assign all permissions to Admin role
        foreach ($permissions as $permission) {
            DB::table('role_permissions')->insert([
                'role_id' => $adminRoleId,
                'permission_name' => $permission['permission_key']
            ]);
        }

        // Create default admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRoleId,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
