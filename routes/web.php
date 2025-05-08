<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/asd', [PageController::class, 'home'])->name('events');
Route::get('/asdasd', [PageController::class, 'home'])->name('about');

