<?php

namespace App\Http\Controllers;

use App\TransportType;
use Illuminate\Http\Request;

class TransportTypesController extends Controller
{
    /**
     *  Get all Transport Types from DB
     * 
     * @return TransportType
     */
    public function index()
    {
        return TransportType::all();
    }
}
