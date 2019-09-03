<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Company;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Store new Comment in DB
     */
    public function store(Company $company, Request $request)
    {
        if(auth()->user()->company->id === $company->id){
            return response()->json('You may not rate own company.', 403);
        }

        $request->validate([
            'rating' => 'required|integer'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'company_id' => $company->id,
            'rating' => $request->rating,
            'body' => $request->body
        ]);
    }

    public function destroy(Comment $comment)
    {
        if(auth()->id() != $comment->user_id){
            return response()->json('You dont have premission to delete this rating.', 403);
        }

        $comment->delete();
    }
}
