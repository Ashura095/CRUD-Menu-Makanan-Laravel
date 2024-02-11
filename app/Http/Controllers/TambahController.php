<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

use Illuminate\Http\Request;

class TambahController extends Controller
{
    public function tambah() : View
    {
        return view('foods.create');
    }
}
