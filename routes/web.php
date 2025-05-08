<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/asd', [PageController::class, 'home'])->name('events');
Route::get('/asdasd', [PageController::class, 'home'])->name('about');

