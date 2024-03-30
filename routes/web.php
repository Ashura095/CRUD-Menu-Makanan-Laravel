<?php

use App\Http\Controllers\ShowController;
use Illuminate\Support\Facades\Route;

//route resource
Route::resource('/foods', \App\Http\Controllers\PostController::class);
Route::resource('/', \App\Http\Controllers\ShowController::class);
