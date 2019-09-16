<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationSettingsController extends Controller
{
    public function update()
    {
        $newsletters = auth()->user()->newsletters;
         
        auth()->user()->update([
            'newsletters' => !$newsletters
        ]);

        if(!$newsletters){
            return response()->json(['message' => __('Newsletters enabled.')]);
        }

        return response()->json(['message' => __('Newsletters disabled.')]);
    }
}
