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
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{  
    /**
     * Login a user
     * 
     * @return Response    
     */
    public function login(Request $request)
    {   
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],            
        ]);

        return $this->passportRequest('password', [
            'username' => $request->email,
            'password' => $request->password
        ]);
    }

    /**
     * Refresh Access Token
     */
    public function refresh()
    {
        $requestToken = request()->cookie('refresh_token');

        return $this->passportRequest('refresh_token', [
            'refresh_token' => $requestToken
        ]);
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
            'address' => ['required'],
            'postcode' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
            'terms_accepted' => ['required', 'boolean', function($attribute, $value, $fail){ 
                if($value == false){
                    $fail(__('Please confirm our terms of use.'));
                };                
            }],                        
        ]);        

        $company = Company::create([
            'name' => $request->company_name,
            'vat' => $request->vat,
            'country' => $request->country,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);       
       
        $user =  User::create([
            'company_id' => $company->id,
            'name' => $request->name,            
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmation_token' => User::makeToken($request->email),
            'terms_accepted_at' => Carbon::now(),
            'payment_terms_accepted_at' => Carbon::now(),
        ]);  

        Mail::to($user)->send(new ConfirmYourEmail($user));

        return $user;
    }

    /**
     *  Logout the current user
     *  Forget Refresh and Access Token Cookies
     */
    public function logout()
    {         
        auth()->user()->tokens->each(function($token){

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $token->id)
                ->delete();

            $token->delete();
        });   
        
        Cookie::queue( Cookie::forget('refresh_token'));
        Cookie::queue( Cookie::forget('access_token'));

        return response()->json(__('Logged out successfully.'), 200);
                
    }

    /**
     * Get logged in User
     * 
     * @return Response
     */
    public function user()
    {       
        return response()->json(request()->user()->load('company'));
    }

    /** 
     *  Delete User Account
     */
    public function destroy()
    {     
        $tenders = auth()->user()->tenders->where('completed_at', NULL);
        $offers = auth()->user()->offers->where('active', true);

        if(!$tenders->isEmpty() || !$offers->isEmpty()){
            return response()->json(['message' => __('You still has active tenders or offers. Please complete them first.')], 420);
        }

        auth()->user()->delete();        
    }

    /**
     *  Make a Request to the OAuth Server
     *  And Set Refresh and Access Tokens
     * 
     * @param stirng $grantType
     * @param array $data
     * @return Response 
     */
    protected function passportRequest($grantType, array $data = [])
    {   
        $http = new Client;  
       
        try {            
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => array_merge($data,[
                    'grant_type' => $grantType,
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),                    
                ])
            ]); 

            $data = json_decode($response->getBody()); 
            
            Cookie::queue(Cookie::make(
                'refresh_token',
                $data->refresh_token,
                14400, // Minutes = 10 days
                null,
                null,
                false,
                true // HttpOnly
            ));

            Cookie::queue(Cookie::make(
                'access_token',
                $data->access_token,
                $data->expires_in,
                null,
                null,
                false,
                false
            ));

            return response([
                'access_token' => $data->access_token,                        
                'expires_in' => $data->expires_in
            ]);

        } catch (BadResponseException $e) {
            if($e->getCode() === 400 ){
                return response()->json(__('Invalid Request. Please check your email or password.'), $e->getCode());
            }else if($e->getCode() === 401){ 
                return response()->json(__('You credentials are incorrect. Please try again.'), $e->getCode());
            }

            return response()->json(__('Something went wrong on the server.'), $e->getCode());
        }
        
    }

}
