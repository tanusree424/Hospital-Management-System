<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    if (Gate::denies('Show Permission')) {
        abort(403, 'Unauthorized access.');
    }

    $permissions = Permission::latest()->get();
    return view('pages.AdminPages.Permissions.index', compact('permissions'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create_permision')) {
           abort(403, 'Unauthorized access.');
        }
        return view('pages.AdminPages.Permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       if (Gate::denies('edit_permission')) {
        abort(403, 'Unauthorized access.');
       }

        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:50",
            "permission_slug"=>"required"
        ]);
        if ($validator->fails()) {
            return redirect()->route('permission.create')->withErrors($validator);
        }
        $permission = Permission::create([
            "name"=>$request->name,
            "permission_slug"=>$request->permission_slug
        ]);
        if ($permission) {
            return redirect()->route('permission.index')->with('success','Permission Created Successfully');
        }
        return redirect()->back()->with('error','Permission not Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         if (Gate::denies('update_permission')) {
            abort(403,'Unauthorized access.');
        }
        $permission = Permission::find($id);
        $validator = Validator::make($request->all(),[
            "name"=>"required|unique:permissions,name,$id",
            "permission_slug"=>"required"
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $permission->update([
            "name"=>$request->name,
            "permission_slug"=>$request->permission_slug
        ]);
        return redirect()->route('permission.index')->with('success','Permission Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete_permission')) {
            abort(403,'Unauthorized access.');
        }
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('success','Permission Deleted Successfully');
    }
}
