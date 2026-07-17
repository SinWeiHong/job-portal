<?php

use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get(
        '/employer/jobs/create',
        [JobPostController::class, 'create']
    )->name('jobs.create');

    Route::post(
        '/employer/jobs',
        [JobPostController::class, 'store']
    )->name('jobs.store');
});