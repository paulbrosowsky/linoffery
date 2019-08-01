<?php

namespace App\Http\Controllers;

use App\Category;

class CategoriesController extends Controller
{
    /**
     *  Show all Categories
     * 
     * @return Category
     */
    public function index()
    {
        return Category::all();
    }
}
