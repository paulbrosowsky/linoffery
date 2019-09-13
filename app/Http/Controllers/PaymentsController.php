<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    /**
     *  Get all Invoices for auth user
     * 
     * @return Invoice
     */
    public function index()
    {        
        return Invoice::where('company_id', auth()->user()->company->id)->get();
    }   
       
    /**
     *  Update auth users payment data
     * 
     *@param Request    
     */
    public function update(Request $request)
    {  
        $company = auth()->user()->company;        

        if(!$company->hasPaymentSubscription){
            if(!$company->stripe_id){
               $company->addAsStripeCustomer($request->token);
            }
            return $company->createPaymentSubscription();
        }

        $company->updatePaymentMethod($request->token);
    }       

      
}
