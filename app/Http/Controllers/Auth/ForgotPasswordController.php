<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     *  Sent Email to authenticated user to reset password
     * 
     * @param Request email
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required | email | exists:users,email'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $user->update([
            'password_reset_token' => User::makeToken($request->email)
        ]);       

        Mail::to($user)->send(new ResetPasswordEmail($user));
    }

     /**
     *  Update Old Password
     * 
     * @param Request password, token
     */
    public function update(Request $request)
    {       
        $request->validate([
            'new_password' => ['required', 'string', 'min:6'],
        ]);        

        $user = User::where('password_reset_token', $request->token)->firstOrFail();

        $user->update([
            'password'              => Hash::make($request->new_password),
            'password_reset_token'  => null
        ]); 

    }
}
