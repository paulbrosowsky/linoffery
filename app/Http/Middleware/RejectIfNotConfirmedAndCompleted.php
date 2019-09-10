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
        $user = $request->user();        

        if (!$user->confirmed || !$user->company->completed || !$user->company->paymentCustomer) {
            return  response()->json([
                'message' => 'Bitte bestätige deine Email-Adresse, oder vervollständige die Firmenadresse'
            ], 401);           
        }  
        return $next($request);
    }

} 
