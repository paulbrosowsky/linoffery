<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'company_id',
        'confirmation_token',
        'position',
        'phone',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token', 
        'created_at', 
        'updated_at', 
        'confirmation_token'        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean'
    ];

    protected $with = ['company'];

    /**
     * A User belongs to a company
     * 
     * @return belongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     *  Generate new Token to confirm users email.
     * 
     * @param string
     * @return string
     */
    public static function makeConfirmationToken($email)
    { 
        return str_limit(md5($email . str_random()), 25, '');
    }

     /**
     *  Confirm the users Email adress
     */
    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;

        $this->save(); 
    }
}
