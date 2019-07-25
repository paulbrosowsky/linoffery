<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'old_password' => ['required', 'string', 'min:6'],
            'new_password' => ['required', 'string', 'min:6']
        ]);
        
        // Compare current password with request value
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return response()->json(['errors' => [
                'old_password' =>['Invalid password.'] 
            ]], 422);
        }
        
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]); 
        
    }
}
