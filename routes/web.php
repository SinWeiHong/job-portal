<?php

use App\Http\Controllers\JobApplicationController;


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
| Job Application Routes — JPW-4
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