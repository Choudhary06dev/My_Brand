<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PermissionService
{
    /**
     * Synchronize permissions with models in app/Models directory.
     */
    public function syncPermissions(): void
    {
        $modelFiles = File::files(app_path('Models'));
        $modelNames = [];

        foreach ($modelFiles as $file) {
            $modelName = $file->getFilenameWithoutExtension();
            // Basic check to exclude base Model or traits if any (though usually stay in Models root)
            if ($modelName !== 'User' && $modelName !== 'Role' && $modelName !== 'Permission') {
                $modelNames[] = $modelName;
            }
        }

        // Add some fixed permissions that might not be models
        $fixedPermissions = ['dashboard', 'settings', 'activity_logs', 'error_logs', 'visitors'];
        
        $allPermissions = array_unique(array_merge(
            array_map(fn($name) => Str::snake($name), $modelNames),
            array_map(fn($name) => Str::plural(Str::snake($name)), $modelNames), // Usually plural form is used in UI
            $fixedPermissions
        ));

        // Let's stick to a convention. The seeder used plural for many.
        // Let's just use plural snake_case for models to match existing seeder style mostly.
        $finalPermissions = [];
        foreach ($modelNames as $name) {
            $key = Str::plural(Str::snake($name));
            
            // Special handling to match existing seeder if needed
            if ($key === 'company_infos') $key = 'company_info';
            
            $finalPermissions[] = [
                'key' => $key,
                'description' => 'Access to ' . Str::headline(Str::plural($name))
            ];
        }

        // Add fixed ones / special ones that were in seeder but not direct models
        $specialKeys = [
            'dashboard' => 'Access to Dashboard',
            'settings' => 'Access to Settings',
            'activity_logs' => 'Access to Activity Logs',
            'error_logs' => 'Access to Error Logs',
            'visitors' => 'Access to Visitors',
            'clients' => 'Access to Clients',
            'certificates' => 'Access to Certificates',
            'product_gallery' => 'Access to Product Gallery',
        ];

        foreach ($specialKeys as $key => $description) {
            $finalPermissions[] = [
                'key' => $key,
                'description' => $description
            ];
        }

        $existingKeys = [];
        foreach ($finalPermissions as $perm) {
            Permission::updateOrCreate(
                ['permission_key' => $perm['key']],
                ['description' => $perm['description']]
            );
            $existingKeys[] = $perm['key'];
        }

        // Cleanup permissions that are no longer associated with a model or fixed list
        // Caution: This might delete custom permissions if they aren't in this logic.
        // But the user specifically asked: "agar koi modal delete ho to wo permission sa automatisc remove ho jia"
        Permission::whereNotIn('permission_key', $existingKeys)->delete();
    }
}
