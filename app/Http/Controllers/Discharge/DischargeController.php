<?php

namespace App\Http\Controllers\Discharge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discharge;

class DischargeController extends Controller
{
    public function create(Request $request)
    {
        $patitentUser = auth()->user()->hasRole('Patient');


    }
}
