<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('Show User');
        $users = User::latest('id')->get();
        $roles =  Role::all();
        return view('pages.AdminPages.Users.index',compact('users','roles'));
    }
    // public function create()

    // {

    //     return view('pages.AdminPages.Users.create', compact('roles'));
    // }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "name"=>"required|string|max:50|min:3",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|confirmed"
        ]);
        if ($validate->fails()) {
            return redirect()->route('user.index')->withErrors($validate);
        }
        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)

        ]);
        if ($request->has('role')) {
           $user->assignRole($request->role);
        }
        return redirect()->route('user.index')->with('success', 'User created and role assigned successfully.');
    }

    // public function edit(string $id )
    // {
    //     $user = User::find($id);
    //     $roles = Role::all();
    //     return view('pages.AdminPages.Users.edit', compact('user','roles'));
    // }

  public function update(string $id, Request $request)
{
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
        "name"  => "required|string|max:50|min:3",
        "email" => "required|email|unique:users,email," . $id,
        "role"  => "required|string|max:15|min:3"
    ]);

    if ($validator->fails()) {
        return redirect()->route('user.edit', $id)
                         ->withErrors($validator)
                         ->withInput();
    }

    $user->update([
        "name"  => $request->name,
        "email" => $request->email
    ]);

    if ($request->has('role')) {
        $user->syncRoles([$request->role]);
    }

    return redirect()->route('user.index')->with('success', 'User & Role Updated Successfully');
}

public function destroy(string $id)
{
    $user = User::find($id);
    $user->delete();
    return redirect()->route('user.index')->with('success','user Deleted Successfully');
}

}
