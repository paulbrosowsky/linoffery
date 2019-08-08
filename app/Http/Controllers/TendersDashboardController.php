<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tender;

class TendersDashboardController extends Controller
{
    /**
     *  Get all Tenders by authenticated user
     * 
     * @return Tender
     */
    public function index()
    {
        return Tender::where('user_id', auth()->id())->latest()->get();
    }
}
