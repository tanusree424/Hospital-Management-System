<?php

namespace App\Http\Controllers\MedicalReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medical_records;

class MedicalReportController extends Controller
{
    public function index()
    {
        $medical_records = Medical_records::with('patient','doctor','appointment')->paginate(5);
        return view('pages.AdminPages.MedicalReports.index', compact('medical_records'));
    }

}
