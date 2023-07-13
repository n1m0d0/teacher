<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(PageController::class)->group(function () {
    Route::get('user', 'user')->name('page.user')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('department', 'department')->name('page.department')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('level', 'level')->name('page.level')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('sublevel', 'sublevel')->name('page.sublevel')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('category', 'category')->name('page.category')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('area', 'area')->name('page.area')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);    
    Route::get('school', 'school')->name('page.school')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('classroom/{school}', 'classroom')->name('page.classroom')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('student/{school}', 'student')->name('page.student')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('attendance/{school}', 'attendance')->name('page.attendance')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('listing/{attendance}', 'listing')->name('page.listing')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
});