<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    public function index()
    {
        return auth()->user()->notifications;
    }

    /**
     *  Delete a given notification from DB
     * 
     * @param uuid
     */
    public function destroy($notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->delete();
    }

    /**
     *  Delete a all notifications from DB     
     */
    public function destroyAll()
    { 
        auth()->user()->notifications()->each(function($notification){
           return  $notification->delete();
        });  
    }
}
