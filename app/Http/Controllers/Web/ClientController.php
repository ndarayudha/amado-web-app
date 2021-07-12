<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    public function index()
    {
        return view('client.layout.home');
    }
}
