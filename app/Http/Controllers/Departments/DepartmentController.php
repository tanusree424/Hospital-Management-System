<?php

namespace App\Http\Controllers\Departments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use Illuminate\Support\Facades\Gate;



class DepartmentController extends Controller
{
    public function index()
    {

        if (Gate::none(['View Department'])) {
           abort(403);
        }
        $departments = Department::latest('id')->get();
        return view('pages.AdminPages.Departments.index', compact('departments'));
    }
    public function create()
    {
        return view('pages.AdminPages.Departments.create');

    }

    public function store(Request $request)
{
    $validate = Validator::make($request->all(), [
        "department_name"   => "required|unique:departments,name",
        "description"       => "required",
        "department_image"  => "nullable|mimes:jpeg,jpg,png|max:2048",
        'price'             => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/' // up to 2 decimals
    ]);

    if ($validate->fails()) {
        return redirect()->route('departments.create')
                         ->withErrors($validate)
                         ->withInput();
    }

    $department = new Department();
    $department->name = $request->department_name;
    $department->description = $request->description;
    $department->pricing = $request->price;

    if ($request->hasFile('department_image')) {
        $imagePath = $request->file('department_image')->store('department_image', 'public');
        $department->department_image = $imagePath;
    }

    if (!$department->save()) {
        return redirect()->back()->with('error', 'Department not created');
    }

    return redirect()->route('departments.index')->with('success', 'Department created successfully');
}


    public function update(string $id, Request $request)
    {
      $department = Department::find($id);
      if (!$department) {
        return redirect()->route('departments.edit', $id)->with('error','Departmet does not exist');
      }
      $validator = Validator::make($request->all(),[
        "department_name"=>"nullable|unique:departments,name,$id",
        "description"=>"nullable",
        "department_image"  => "nullable|mimes:jpeg,jpg,png|max:2048",
        'price'             => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/' // up to 2 decimals
      ]) ;
      if ($validator->fails()) {
        return redirect()->route('departments.edit', $id)->withErrors($validator);
      }
    if ($request->department_name) {
       $department->name =  $request->department_name;
    }
    if ($request->description) {
       $department->description =  $request->description;
    }
    if ($request->hasFile('department_image')) {
         if ($department->department_image && \Storage::disk('public')->exists($department->department_image)) {
            \Storage::disk('public')->delete($department->department_image);
        }
        $imagePath =  $request->file('department_image')->store('department_image','public');
        $department->department_image = $imagePath;
    }
    if ($request->price) {
         $department->pricing = $request->price;
    }
    if (!$department->save()) {
        return redirect()->route('departments.index')->with('error','department not getting updated');
    }
      return redirect()->route('departments.index')->with('success','Department Updated Successfully');
    }

    public function destroy(string $id)
{
    $department = Department::find($id);

    if (!$department) {
        return redirect()->route('departments.index')->with('error', 'Department does not exist.');
    }

    $department->delete();

    return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
}


}
