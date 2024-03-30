<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;

use App\Models\Post;

class ShowController extends Controller
{
    public function index(): View
    {
        //get posts
        $foods = post::latest()->paginate(8);

        //render view with posts
        return view('foods.home', compact('foods'));
    }
    public function show(string $id): View
    {
        //get post by ID
        $food = post::findOrFail($id);

        //render view with post
        return view('home.show', compact('food'));
    }
}
