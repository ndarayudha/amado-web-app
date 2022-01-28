<?php

namespace App\Http\Controllers;

use App\Mail\KonfirmasiMail;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailAwsController extends Controller
{
    public function sendKonfirmasiEmail(Request $request){
        $patient = Patient::find($request->id_patient);

        $kode = $request->kode_konfirmasi;
        $data = array('kode' => $kode, 'name' => $patient->name);
        
        Mail::to($patient->email)->send(new KonfirmasiMail($data));
        $patient->update([
            'konfirmasi' => 'Terkonfirmasi'
        ]); 
        return response()->json([
            'data' => $request->all()
        ]);
    }
}
