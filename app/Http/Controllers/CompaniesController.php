<?php

namespace App\Http\Controllers;

use App\Jobs\ValidateVat;
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

        $company->update([
            'name' => $request->name,
            'country' => $request->country,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'website' => $request->website,
        ]);
        
        // Trigger Validation If VAT Changed
        if($request->vat != $company->vat){
            $request->validate([
                'vat' => ['required', 'string', 'max:15', 'alpha_num', 'unique:companies']
            ]);
            
            $company->update([
                'vat' => $request->vat,
                'vat_validated_at' => NULL
            ]);

            ValidateVat::dispatch($company);
        }        

        return response()->json(['message' => 'Your companies data were successfully updated.' ], 200);
    }
}
