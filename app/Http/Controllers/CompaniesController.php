<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompaniesController extends Controller
{   
    /**
     *  Updata company data
     * 
     * @param Request
     * @return Json
     */
    public function update(Request $request)
    {
        $company = auth()->user()->company;

        $request->validate([
            'name' => ['required', 'string'],            
            'address' => ['required'],
            'postcode' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
        ]);

        if($request->vat != $company->vat){
            $request->validate([               
                'vat' => ['required', 'string', 'max:20', 'alpha_num', 'unique:companies', 'vat-number'],                
            ]);
        }

        $company->update([
            'name' => $request->name,
            'vat' => $request->vat,
            'country' => $request->country,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'website' => $request->website
        ]);

        return response()->json(['message' => 'Your companys data were successfully updated.' ], 200);
    }
}
