<?php

use App\Http\Controllers\TambahController;
use Illuminate\Support\Facades\Route;

//route resource
Route::resource('/foods', \App\Http\Controllers\PostController::class);
Route::get('/tambah', [TambahController::class,'tambah']);
