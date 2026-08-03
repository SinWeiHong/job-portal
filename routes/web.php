<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
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
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [LoginController::class, 'destroy']
    )->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Create Job Posting — JPW-7
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

    /*
    |--------------------------------------------------------------------------
    | Apply for Job — JPW-4
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/jobs/{jobPost}/apply',
        [JobApplicationController::class, 'create']
    )->name('applications.create');

    Route::post(
        '/jobs/{jobPost}/apply',
        [JobApplicationController::class, 'store']
    )->name('applications.store');
});