<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PasswordSettingsController extends Controller
{
    /**
     * Update password
     * 
     * @param Request
     */
    public function update(Request $request)
    {  
        $request->validate([
            'old_password' => [
                'required', 
                'string', 
                'min:6',
                function($attribute, $value, $fail){
                    if(!Hash::check($value, auth()->user()->password)){
                        $fail(__('This password is invalid.'));
                    }
                }
            ],
            'new_password' => ['required', 'string', 'min:6']
        ]);
        
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]); 
        
    }
}
