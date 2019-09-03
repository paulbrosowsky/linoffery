<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     *  Fetch specific Company form DB
     * 
     * @param id
     * @return Company
     */
    public function show(Company $company)
    {
        return $company->append(['shipmentCount', 'tenderCount'])->load('comments.user');
    }
}
