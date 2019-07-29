<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Mail\ConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class EmailConfirmationController extends Controller
{
    /**
     *  Confirm the user email address
     */
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();      
        
        if (! $user) {
            return redirect('/')
                ->with('flash', 'Zugangsschluessel ungueltig.');
        }

        $user->confirm(); 
        
        return redirect('/dashboard')
            ->with('flash', 'Du hast deien Anmeldung bestätigt. Herzlich Willkommen!');
    }

    /**
     *  Send Confirmation Email to authenticated user
     */
    public function update()
    {
        $user = auth()->user();

        if(!$user->cofirmed){
           
            $user->update([
                'confirmation_token' => User::makeToken($user->email)
            ]);            
            
            Mail::to($user)->send(new ConfirmYourEmail($user));
        }
        
    }
}
