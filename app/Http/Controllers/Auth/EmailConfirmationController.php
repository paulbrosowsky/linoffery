<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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
}
