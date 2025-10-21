<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GruposEconomicosController extends Controller
{
    public function index()
    {
        return view('grupos_economicos');
    }
}
