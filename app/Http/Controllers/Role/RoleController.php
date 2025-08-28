<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
{
    Gate::authorize('Show role'); // blocks at backend too
    $roles = Role::latest('id')->get();
    $permissions = Permission::all();

        // $rolePermissions = $roles->permissions->pluck('name')->toArray();
    return view('pages.AdminPages.Roles.index', compact('roles','permissions'));
}


    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        Gate::authorize('create-role');


        return view('pages.AdminPages.Roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-role');

        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:50|unique:roles,name"
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput()
                ->with('error', 'Validation failed!');
        }

        $role = Role::create([
            "name" => $request->name,
            "guard_name" => "web",
            "created_at" => now(),
            "updated_at" => now()
        ]);

        if ($request->has('permission')) {
            $role->syncPermissions($request->permission);
        }

        return redirect()->route('role.index')->with('success', 'Role added successfully!');
    }
    /**
     * Update role.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-role');

        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed!');
        }

        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('role.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Delete role.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-role');

        $role = Role::find($id);

        if (!$role) {
            return redirect()->back()->withErrors(['error' => 'No Role Found']);
        }

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully');
    }
}
