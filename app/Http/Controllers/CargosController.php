<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
use Carbon\Carbon;

class CargosController extends Controller
{
    /**
     *  Get all Cargos
     */
    public function index()
    {          
        return Cargo::all();
    }

    /**
     * Get a given Cargo
     */
    public function show(Cargo $cargo)
    {        
        return $cargo;
    }
}
