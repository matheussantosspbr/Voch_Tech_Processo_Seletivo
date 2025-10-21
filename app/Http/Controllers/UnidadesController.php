<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnidadesController extends Controller
{
    public function index()
    {
        return view('unidades');
    }
}
