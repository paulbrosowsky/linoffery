<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasAvatar, HasCustomId, Billable, SoftDeletes;

    protected $guarded = [];

    protected $appends = ['completed', 'rating', 'hasPaymentSubscription'];    

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'stripe_id', 
        'card_brand', 
        'card_last_for', 
        'trail_ends_at'              
    ];

    protected static function boot(){
        parent::boot();

        static::deleting(function($company){
            $company->deleteStipeCustomer();
        });
    }

    /**
     *  A company has many comments
     * 
     * @return hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }    

    /**
     *  Company has one user
     * 
     * @return hasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the right logo path
     * 
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {       
        $exists = Storage::disk('public')->exists($avatar);  
              
        if ($exists) {
            return '/storage/'. $avatar;
        }
        
        return '/storage/build/images/default_logo.svg';    
    }  

    /**
     *  Check if company has a full address
     * 
     * @return boolean
     */
    public function getCompletedAttribute()
    {        
        return !empty($this->address && $this->postcode && $this->city && $this->country);
    }

    /**
     *  Get Shipment count of the company
     * 
     * @return integer
     */
    public function getShipmentCountAttribute()
    {
        return Order::where('carrier_id', $this->user->id)->count();        
    }

    /**
     *  Get active tender count 
     * 
     * @return integer
     */
    public function getTenderCountAttribute()
    {        
        return $this->user->tenders()->where('published_at', '!=', NULL)->count();                   
    }

     /**
     *  Get average rating 
     * 
     * @return integer
     */
    public function getRatingAttribute()
    {    
        if(isset($this->comments)){
            $ratingSum = 0;
            $commentsCount = $this->comments()->count();

            foreach ($this->comments as $comment) {
                $ratingSum = $ratingSum + $comment->rating;
            }  

            return  $commentsCount > 0 ? $ratingSum / $commentsCount : null;
        }         
    } 

    /**
     * Get Payment Customer Attribute
     * 
     * @return boolean
     */
    public function getHasPaymentSubscriptionAttribute()
    {   
        return !empty($this->paymentSubscription);
    }
    
}
