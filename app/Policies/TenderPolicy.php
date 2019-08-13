<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Tender;

class TenderPolicy
{
    use HandlesAuthorization;

   /**
     * Determine wethet the user can update the tender
     * 
     * @param \App\User $user
     * @param \App\Tender $tender
     * @return mixed
    */
    public function update(User $user, Tender $tender)
    {   
        $userId = $tender->user_id;

        if (gettype($userId) == 'string') {
            $userId = intval($userId);
        }
        // Update when owner and tender not published
        return $userId === $user->id && $tender->published_at === NULL;    
    }

     /**
     * Determine wethet the user can view the tender
     * 
     * @param \App\User $user
     * @param \App\Tender $tender
     * @return mixed
    */
    public function show(?User $user, Tender $tender)
    {           
        $userId = $tender->user_id;        
        if (gettype($tender->user_id) == 'string') {
            $userId = intval($userId);
        } 

        // If tender umpublished check for owner
        return $userId === auth('api')->id();
    }
}
