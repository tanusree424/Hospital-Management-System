<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('pages.AdminPages.Services.index', compact('services'));
    }

  public function store(Request $request)
{
    $request->validate([
        "title" => "required|string|min:3|max:50",
        "description" => "required|string",
        "price" => "required|numeric|min:0",
        "status" => "nullable|in:active,deactive",
        "icon" => "nullable|string",
        "link" => "nullable|url"
    ]);

    Service::create($request->all());

    return redirect()
        ->route('admin.services.index')
        ->with('success', 'Service created successfully!');
}




public function update(Request $request, $id)
{
    // Validate input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'icon' => 'nullable|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'link' => 'nullable|url',
        'status' => 'required|in:active,deactive',
    ]);

    // Find the service
    $service = Service::findOrFail($id);

    // Update the service with validated data
    $service->update($validated);

    // Redirect back with success message
    return redirect()
        ->back()
        ->with('success', 'Service updated successfully!');
}

public function destroy($id)
{
    $service = Service::findOrFail($id);
    if (!$service) {
       return redirect()->back()->with('error',"Service {$service->title} Not Found");
    }
    $service->delete();
    return redirect()->route('admin.services.index')->with('success','Deleted Successfully');
}



}
