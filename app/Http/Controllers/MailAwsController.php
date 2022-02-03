<?php

namespace App\Http\Controllers;

use App\Mail\KonfirmasiMail;
use App\Mail\KonfirmasiRekamMedisMail;
use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailAwsController extends Controller
{
    public function sendKonfirmasiEmail(Request $request)
    {
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

    public function emailKonfirmasiRekamMedis(Request $request)
    {
        $record = MedicalRecord::find($request->record_id);
        $patient = $record->patient()->first();

        $record_url = $record->url;
        $patient_name = $patient->name;
        $patient_email = $patient->email;

        $data = [
            'name' => $patient_name,
            'url' => $record_url,
            'email' => $patient_email
        ];


        Mail::to($patient_email)->send(new KonfirmasiRekamMedisMail($data));

        // return view('mail.records', $data);

        return response()->json([
            'code' => 200,
            'pesan' => 'email rekam medis berhasil'
        ]);
    }
}
