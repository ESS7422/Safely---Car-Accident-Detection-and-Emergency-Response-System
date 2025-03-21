<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Medical_case;
use App\Models\User_medical_case;
use Illuminate\Support\Facades\Validator;


class MedicalController extends Controller
{


public function medicalCase(Request $request)
{
    $validated = $request->validate([
        'blood_type' => 'required|string',
        'blood_pressure' => 'required|string',
        'diabetes' => 'nullable',
        'another_health_problem' => 'nullable|string',
    ]);

    $medical = Medical_case::create([
        'blood_type' => $validated['blood_type'],
        'blood_pressure' => $validated['blood_pressure'],
        'diabetes' => $validated['diabetes'],
        'another_health_problem' => $validated['another_health_problem'],
    ]);
    User_medical_case::create([
        'user_id' => Auth::user()->id,
        'medical_case_id' => $medical->id,
    ]);

    return response()->json([
        'message' => 'Medical case created',
        'data' => $medical,
    ]);

}



}
