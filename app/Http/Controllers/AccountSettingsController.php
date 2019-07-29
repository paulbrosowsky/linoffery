<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Mail\ConfirmYourEmail;
use Illuminate\Support\Facades\Mail;

class AccountSettingsController extends Controller
{
    /**
     *  Update user account
     * 
     * @param request
     * @return User
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],            
            'position' => ['max:255'],
            'phone' => ['max:255']
        ]);

        $user = auth()->user();

        if ($request->email != $user->email) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'] 
            ]);

            $this->mustConfirmEmail($request->email);
        }
       
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'phone' => $request->phone
        ]);

        return $user;
    }

    /**
     * Set sonfirmation data and send confirmation Email
     * 
     * @param string $email    
     */
    protected function mustConfirmEmail($email)
    {        
        auth()->user()->update([
            'confirmed' => false,
            'confirmation_token' => User::makeToken($email)
        ]);

        Mail::to(auth()->user())->send(new ConfirmYourEmail(auth()->user()));
    }
}
