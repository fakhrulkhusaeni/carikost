<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromosiController extends Controller
{

    public function index()
    {
        return view('admin.promosi.index');
    }


}
