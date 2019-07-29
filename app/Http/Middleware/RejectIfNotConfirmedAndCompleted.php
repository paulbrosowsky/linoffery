<?php

namespace App\Http\Middleware;

use Closure;

class RejectIfNotConfirmedAndCompleted
{
    /**
     *  Reject if Email not confirmed and company's data not completed 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->confirmed || $this->companyAddressNotCompleted($request->user)) {
            return  response()->json([
                'message' => 'Bitte bestätige deine Email-Adresse.'
            ], 401);           
        }  
        return $next($request);
    }

    /** Chack if Company's data are completed
     * 
     * @param User
     * @return boolean
     */
    protected function companyAddressNotCompleted($user)
    {
        $company = $user->company;

        if (
            $company->address->exists()
            && $company->postcode->exists()
            && $company->city>exists()
            && $company->country>exists()
        ){
            return false;
        }

        return true;
    }
}
