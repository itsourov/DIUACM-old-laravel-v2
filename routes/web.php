<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/settings', [PageController::class, 'settings'])->name('settings');

// Contact routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Contest routes
Route::get('/contests', [ContestController::class, 'index'])->name('contest.index');
Route::get('/contests/{id}', [ContestController::class, 'show'])->name('contest.show');

// Event routes
Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('event.show');
Route::post('/events/{id}/attendance', [EventController::class, 'markAttendance'])->name('event.attendance')->middleware('auth');

// Programmer routes
Route::get('/programmers', [ProgrammerController::class, 'index'])->name('programmer.index');
Route::get('/programmers/{username}', [ProgrammerController::class, 'show'])->name('programmer.show');

// Tracker routes
Route::get('/trackers', [TrackerController::class, 'index'])->name('tracker.index');
Route::get('/trackers/{slug}', [TrackerController::class, 'show'])->name('tracker.show');

// Ranklist routes
Route::post('/ranklists/{rankList}/join', [TrackerController::class, 'joinRankList'])->name('ranklist.join')->middleware('auth');
Route::delete('/ranklists/{rankList}/leave', [TrackerController::class, 'leaveRankList'])->name('ranklist.leave')->middleware('auth');

require __DIR__.'/auth.php';
