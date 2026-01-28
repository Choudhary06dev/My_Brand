<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'permission_key' => 'dashboard',
                'description' => 'Access to Dashboard'
            ],
            [
                'permission_key' => 'users',
                'description' => 'Access to Users Management'
            ],
            [
                'permission_key' => 'roles',
                'description' => 'Access to Roles Management'
            ],
            [
                'permission_key' => 'company_info',
                'description' => 'Access to Company Info'
            ],
            [
                'permission_key' => 'services',
                'description' => 'Access to Services'
            ],
            [
                'permission_key' => 'product_categories',
                'description' => 'Access to Product Categories'
            ],
            [
                'permission_key' => 'products',
                'description' => 'Access to Products'
            ],
            [
                'permission_key' => 'blogs',
                'description' => 'Access to Blogs'
            ],
            [
                'permission_key' => 'sliders',
                'description' => 'Access to Sliders'
            ],
            [
                'permission_key' => 'job_openings',
                'description' => 'Access to Job Openings'
            ],
            [
                'permission_key' => 'job_applications',
                'description' => 'Access to Job Applications'
            ],
            [
                'permission_key' => 'email_templates',
                'description' => 'Access to Email Templates'
            ],
            [
                'permission_key' => 'contact_messages',
                'description' => 'Access to Contact Messages'
            ],
            [
                'permission_key' => 'activity_logs',
                'description' => 'Access to Activity Logs'
            ],
            [
                'permission_key' => 'error_logs',
                'description' => 'Access to Error Logs'
            ],
            [
                'permission_key' => 'visitors',
                'description' => 'Access to Visitors'
            ],
            [
                'permission_key' => 'clients',
                'description' => 'Access to Clients'
            ],
            [
                'permission_key' => 'certificates',
                'description' => 'Access to Certificates'
            ],
            [
                'permission_key' => 'product_gallery',
                'description' => 'Access to Product Gallery'
            ],
            [
                'permission_key' => 'settings',
                'description' => 'Access to Settings'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['permission_key' => $permission['permission_key']],
                ['description' => $permission['description']]
            );
        }
    }
}
