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
        // $userId = $tender->user_id;

        // if (gettype($userId) == 'string') {
        //     $userId = intval($userId);
        // }
        // Update when owner and tender not published
        return intval($tender->user_id) === $user->id && $tender->published_at === NULL;    
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
        // $userId = $tender->user_id;        
        // if (gettype($tender->user_id) == 'string') {
        //     $userId = intval($userId);
        // } 
        
        // If tender umpublished check for owner
        return intval($tender->user_id) === auth('api')->id();
    } 
    
     /**
     * Determine wethet the user can destroy the tender
     * 
     * @param \App\User $user
     * @param \App\Tender $tender
     * @return mixed
    */
    public function destroy(User $user, Tender $tender)
    {  
        $owns = intval($tender->user_id) === $user->id;
        $completed =  $tender->completed_at != NULL;
        $noOrder = $tender->order === NULL ; 
        $draft = $tender->published_at === NULL;       

        return $owns && ($completed || $draft) && $noOrder;    
    }

}
