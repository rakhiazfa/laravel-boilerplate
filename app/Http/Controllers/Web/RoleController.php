<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::orderBy('id', 'DESC')->get();

        return view('role_and_permission')->with([
            'roles' => $roles,
            'permissions' => $permissions,
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
    public function givePermission(Request $request, Role $role)
    {
        $request->validate(['permission_id' => ['required', 'numeric']]);

        $role->givePermissionTo($request->input('permission_id'));

        return back()->with('success', 'Successfully granted permissions to the role.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function revokePermission(Request $request, Role $role)
    {
        $request->validate(['permission_id' => ['required', 'numeric']]);

        $role->revokePermissionTo($request->input('permission_id'));

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
