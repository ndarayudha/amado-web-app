<?php

namespace App\Http\Controllers;

use App\Models\Patient\Patient;
use Illuminate\Http\Request;

class KonfrimasiController extends Controller
{
    public function getPatientById(Request $request)
    {
        $patient = Patient::find($request->id);
        
        return response()->json([
            "code" => 200,
            'patient' => $patient
        ]); 
    }
}
