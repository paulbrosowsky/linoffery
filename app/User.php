<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasAvatar, SoftDeletes;

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
        'confirmed',
        'confirmation_token',
        'position',
        'phone',
        'avatar',
        'password_reset_token',
        'newsletters',
        'deleted_at'
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
        'confirmation_token',
        'password_reset_token'       
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean',
        'newsletters' => 'boolean'
    ];

    protected $with = ['company'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($user){
            $user->tenders()->each(function($tender){
                $tender->destroyTender();
            });

            $user->offers()->each(function($offer){
                $offer->destroyOffer();
            });

            $user->comments()->each(function($comment){
                $comment->delete();
            });

            $user->company->delete();            
        });
    }

    /**
     * A User belongs to a company
     * 
     * @return belongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

     /**
     * A user has many tenders
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }  

    /**
     * A user has many offers
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    } 

    /**
     * A user has many comments
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    

    /**
     *  Generate new Token to confirm users email.
     * 
     * @param string
     * @return string
     */
    public static function makeToken($email)
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
