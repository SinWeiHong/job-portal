<?php

use App\Http\Controllers\AdminJobPostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Registration Routes — JPW-1
|--------------------------------------------------------------------------
*/

Route::get(
    '/register',
    [RegisterController::class, 'create']
)->name('register');

Route::post(
    '/register',
    [RegisterController::class, 'store']
)->name('register.store');

/*
|--------------------------------------------------------------------------
| Login Routes — JPW-11
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [LoginController::class, 'create']
)->name('login');

Route::post(
    '/login',
    [LoginController::class, 'store']
)->name('login.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::post(
        '/logout',
        [LoginController::class, 'destroy']
    )->name('logout');

    /*
|--------------------------------------------------------------------------
| Administrator Job Moderation Routes — JPW-13
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/job-postings',
    [AdminJobPostController::class, 'index']
)->name('admin.job-posts.index');

Route::get(
    '/admin/job-postings/{jobPost}',
    [AdminJobPostController::class, 'show']
)->name('admin.job-posts.show');

    /*
    |--------------------------------------------------------------------------
    | Employer Job Posting Routes — JPW-7
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/employer/jobs/create',
        [JobPostController::class, 'create']
    )->name('jobs.create');

    Route::post(
        '/employer/jobs',
        [JobPostController::class, 'store']
    )->name('jobs.store');
});