<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = []; 

    /**
     *  A Commnet belongs to an user
     * 
     * @return belongTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *  A Commnet belongs to a company
     * 
     * @return belongTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }   
}
