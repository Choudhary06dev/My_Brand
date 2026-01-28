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
        $existingKeys = ['dashboard', 'settings', 'error_logs']; // Essential non-model or special permissions

        foreach ($modelFiles as $file) {
            $modelName = $file->getFilenameWithoutExtension();
            
            // Exclude Permission model itself
            if ($modelName === 'Permission') {
                continue;
            }

            // Standard naming: Plural Snake Case (e.g., Blog -> blogs)
            $key = Str::plural(Str::snake($modelName));

            // Special handling for specific models to match user preference or table names
            if ($modelName === 'CompanyInfo') {
                $key = 'company_info';
            }
            if ($modelName === 'ActivityLog') {
                $key = 'activity_logs';
            }
            if ($modelName === 'ContactMessage') {
                $key = 'contact_messages';
            }
            if ($modelName === 'ProductGallery') {
                $key = 'product_galleries';
            }

            Permission::updateOrCreate(
                ['permission_key' => $key],
                ['description' => 'Access to ' . Str::headline($key)]
            );
            $existingKeys[] = $key;
        }

        // Ensure essential keys exist
        foreach (['dashboard' => 'Access to Dashboard', 'settings' => 'Access to Settings', 'error_logs' => 'Access to Error Logs'] as $key => $desc) {
            Permission::updateOrCreate(
                ['permission_key' => $key],
                ['description' => $desc]
            );
            $existingKeys[] = $key; // Add to existing keys list if not already there
        }

        $existingKeys = array_unique($existingKeys);

        // Cleanup: Remove any permission that is not in our active model/essential list
        Permission::whereNotIn('permission_key', $existingKeys)->delete();

        // Automatically assign all sync'd permissions to Admin role (ID: 1)
        foreach ($existingKeys as $key) {
            \DB::table('role_permissions')->updateOrInsert(
                ['role_id' => 1, 'permission_name' => $key]
            );
        }
    }
}
