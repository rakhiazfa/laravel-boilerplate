<?php

namespace App\Http\Controllers\Web\RolesAndPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function permissions(Request $request)
    {
        $q = $request->get('q', false);

        $roles = Role::with('permissions')->where('name', '!=', 'super-admin')->get();

        $permissions = Permission::when($q, function ($query) use ($q) {
            $query->where('name', 'LIKE', "%$q%");
        })->orderBy('id', 'DESC')->paginate(15);
        $permissions->withQueryString();

        $permissionOptions = Permission::orderBy('id', 'DESC')->get();

        return view('roles_and_permissions.roles_and_permissions')->with([
            'roles' => $roles,
            'permissions' => $permissions,
            'permissionOptions' => $permissionOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['role_name' => ['required', 'unique:roles,name']]);

        Role::create(['name' => $request->input('role_name')]);

        return back()->with('success', 'Successfully created a new role.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function givePermissions(Request $request, Role $role)
    {
        $request->validate(['permission_ids' => ['required']]);

        $role->givePermissionTo($request->input('permission_ids'));

        return back()->with('success', 'Successfully granted permissions to the role.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function revokePermissions(Request $request, Role $role)
    {
        $request->validate(['permission_ids' => ['required']]);

        $role->permissions()->detach($request->input('permission_ids'));
        $role->forgetCachedPermissions();

        return back()->with('success', 'Successfully revoked role permissions.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate(['role_name' => ['required', 'unique:roles,name,' . $role->id]]);

        $role->update(['name' => $request->input('role_name')]);

        return back()->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }
}
