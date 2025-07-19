<?php

namespace App\Http\Controllers\Departments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest('id')->paginate(5);
        return view('pages.AdminPages.Departments.index', compact('departments'));
    }
    public function create()
    {
        return view('pages.AdminPages.Departments.create');

    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "department_name"=>"required|unique:departments,name",
            "description"=>"required"
        ]);
        if ($validate->fails()) {
            return redirect()->route('departments.create')->withErrors($validate);
        }
        $departments = Department::create([
            "name"=>$request->department_name,
            "description"=>$request->description
        ]);
        if (!$departments) {
          return redirect()->back()->with('error','Not Created Department');
        }
        return redirect()->route('departments.index')->with('success','Department created Successfully');

    }
    public function edit(string $id , Request $request)
    {
        $department = Department::find($id);
        return view('pages.AdminPages.Departments.Edit', compact('department'));
    }
    public function update(string $id, Request $request)
    {
      $department = Department::find($id);
      if (!$department) {
        return redirect()->route('departments.edit', $id)->with('error','Departmet does not exist');
      }
      $validator = Validator::make($request->all(),[
        "department_name"=>"required|unique:departments,name,$id",
        "description"=>"required"
      ]) ;
      if ($validator->fails()) {
        return redirect()->route('departments.edit', $id)->withErrors($validator);
      }
      $department->update([
        "name"=>$request->department_name,
        "description"=>$request->description
      ]);
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
