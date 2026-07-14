<?php

use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/employer/jobs/create',
    [JobPostController::class, 'create']
)->name('jobs.create');