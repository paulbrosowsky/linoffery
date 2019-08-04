<?php

namespace App\Http\Controllers\Auth;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Exception\BadResponseException;
use App\Company;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmYourEmail;

class AuthController extends Controller
{  
    /**
     * Login a user
     * 
     * @return Response
     */
    public function login(Request $request)
    {        
        $http = new Client;  
    
        try {            
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password
                ]
            ]); 
                   
            return $response->getBody(); 

        } catch (BadResponseException $e) {
            if($e->getCode() === 400 ){
                return response()->json(__('Invalid Request. Please check your email or password.'), $e->getCode());
            }else if($e->getCode() === 401){ 
                return response()->json(__('You credentials are incorrect. Please try again.'), $e->getCode());
            }

            return response()->json(__('Something went wrong on the server.'), $e->getCode());
        }

    }

    /**
     * Register a new user
     * 
     * @return App\User
     */
    public function register(Request $request)
    {    

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'company_name' => ['required', 'string'],
            'vat' => ['required', 'string', 'max:20', 'alpha_num', 'unique:companies'],
        ]);        

        $company = Company::create([
            'name' => $request->company_name,
            'vat' => $request->vat
        ]);
       
        $user =  User::create([
            'company_id' => $company->id,
            'name' => $request->name,            
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmation_token' => User::makeToken($request->email)
        ]);        

        Mail::to($user)->send(new ConfirmYourEmail($user));

        return $user;

    }

    /**
     *  Logout the current user
     */
    public function logout()
    {        
        auth()->user()->tokens->each(function($token, $key){
            $token->delete();
        });

        return response()->json(__('Logged out successfully.'), 200);
    }

    /**
     * Get logged in User
     * 
     * @return Response
     */
    public function user()
    {
        return response()->json(request()->user());
    }

}
