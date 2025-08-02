<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Medicine;

class HospitalController extends Controller
{
    public function index()
{
    $wards = Ward::all();
    $beds = Bed::with('ward')->get(); // assuming relation
    $medicines = Medicine::all();

    return view('pages.AdminPages.hospital.management', compact('wards', 'beds', 'medicines'));
}

public function wardstore(Request $request)
{
   $validate= $request->validate([
        "name"=>"required|min:3",
        "capacity"=>"required",
        "description"=>"nullable"
    ]);
    // if ($validate->fails()) {
    // return redirect()->back()->with($validate);
    // }

    $ward = Ward::create([
        "name"=>$request->name,
        "capacity"=>$request->capacity,
        "description"=>$request->description
    ]);
    return redirect()->route('hospital.management')->with('success','Ward Created Successfully');

}

public function editWard(Request $request)
{
    $request->validate([
        'id'     => 'required|exists:wards,id',
        'name'        => 'required|min:3',
        'capacity'    => 'required|integer|min:1',
        'description' => 'nullable|string'
    ]);

    $ward = Ward::findOrFail($request->id);

    $ward->update([
        'name'        => $request->name,
        'capacity'    => $request->capacity,
        'description' => $request->description,
    ]);

    return redirect()->route('hospital.management')->with('success', 'Ward updated successfully');
}

public function destroy(string $id)
{
    $ward = Ward::find($id);
    $ward->delete();
    return redirect()->route('hospital.management')->with('ward_success','ward deleted successfully');

}

// Beds Related Methods

public function bedstore(Request $request)
{
    $validated = $request->validate([
        "ward_id"     => "required|exists:wards,id",
        "bed_number"  => "required|string|max:255|unique:beds,bed_number",
        "status"      => "nullable|in:available,occupied,maintenance",
        "description" => "nullable|string",
    ]);

    Bed::create([
        "ward_id"     => $validated['ward_id'],
        "bed_number"  => $validated['bed_number'],
        "status"      => $validated['status'] ?? 'available',
        "description" => $validated['description'],
    ]);

    return redirect()->route('hospital.management')->with('success', 'Bed Added Successfully');
}


public function bedupdate(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:beds,id',
        'bed_number' => 'required|string|max:255',
        'ward_id' => 'required|exists:wards,id',
        'status' => 'required|in:available,occupied',
        'description' => 'nullable|string'
    ]);

    // Find the bed record
    $bed = Bed::findOrFail($request->id);

    // Update the bed
    $bed->update([
        'bed_number' => $request->bed_number,
        'ward_id' => $request->ward_id,
        'status' => $request->status,
        'description' => $request->description
    ]);
    return redirect()->route('hospital.management')->with('success','Bed Updated Successfully');

}
public function beddestroy(string $id)
{
    $bed = Bed::findOrFail($id);
    if ($bed) {
       $bed->delete();
        return redirect()->route('hospital.management')->with('success','Bed deleted Successfully');
    }
     return redirect()->route('hospital.management')->with('bed_failure','Bed not found');

}


public function getBedsByWard(Request $request)
{
    $wardId = $request->ward_id;
    $currentBedId = $request->current_bed_id;

    $beds = \App\Models\Bed::where('ward_id', $wardId)
        ->where(function ($query) use ($currentBedId) {
            $query->where('status', 'available')
                  ->orWhere('id', $currentBedId); // Ensure current bed is included
        })
        ->get();

    return response()->json($beds);
}


// Medicine methods

public function medicinestore(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'stock' => 'required|integer|min:0',
        'manufacturer' => 'nullable|string|max:255',
        'dosage' => 'nullable|integer|min:1',
        'expiry_date' => 'nullable|date',
        'description' => 'nullable|string',
    ]);

    Medicine::create($validated);

    return redirect()->back()->with('medicine_success', 'Medicine added successfully.');
}




    // Update an existing medicine
public function medicineupdate(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:medicines,id',
        'name' => 'required|string|min:2|max:255',
        'type' => 'required|string|max:255', // stored as category in DB
        'stock' => 'required|integer|min:0',
        'manufacturer' => 'nullable|string|max:255',
        'dosage' => 'nullable|integer|min:0',
        'expiry_date' => 'nullable|date',
        'description' => 'nullable|string',
    ]);

    $medicine = Medicine::findOrFail($validated['id']);

    $medicine->update([
        'name' => $validated['name'],
        'category' => $validated['type'], // map `type` to `category`
        'stock' => $validated['stock'],
        'manufacturer' => $validated['manufacturer'] ?? null,
        'dosage' => $validated['dosage'] ?? null,
        'expiry_date' => $validated['expiry_date'] ?? null,
        'description' => $validated['description'] ?? null,
    ]);

    return redirect()->back()->with('medicine_success', 'Medicine updated successfully!');
}



    // Delete a medicine
    public function medicinedestroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->back()->with('medicine_success', 'Medicine deleted successfully!');
    }

}
