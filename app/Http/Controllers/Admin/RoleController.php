<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->permissionService->syncPermissions();
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['role_name' => $request->role_name]);

        if ($request->has('permissions')) {
            // Get permission names instead of IDs
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('permission_key')->toArray();
            \Log::info('Storing permission names:', ['permissions' => $permissions]);

            // Manually insert permission names into pivot table
            $pivotData = [];
            foreach ($permissions as $permissionName) {
                $pivotData[] = [
                    'role_id' => $role->id,
                    'permission_name' => $permissionName
                ];
            }

            \DB::table('role_permissions')->insert($pivotData);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $this->permissionService->syncPermissions();
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['role_name' => $request->role_name]);

        // Delete existing permissions for this role
        \DB::table('role_permissions')->where('role_id', $role->id)->delete();

        if ($request->has('permissions')) {
            // Get permission names instead of IDs
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('permission_key')->toArray();
            \Log::info('Update - Storing permission names:', ['permissions' => $permissions]);

            // Manually insert permission names into pivot table
            $pivotData = [];
            foreach ($permissions as $permissionName) {
                $pivotData[] = [
                    'role_id' => $role->id,
                    'permission_name' => $permissionName
                ];
            }

            \DB::table('role_permissions')->insert($pivotData);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
