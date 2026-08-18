<?php

use App\Http\Controllers\AdminJobPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAccountIsActive;


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

Route::middleware([
    'auth',
    EnsureAccountIsActive::class,
])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard and Logout
    |--------------------------------------------------------------------------
    */

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
    '/admin/job-postings/{jobPost}/remove',
    [AdminJobPostController::class, 'remove']
)->name('admin.job-posts.remove');

Route::delete(
    '/admin/job-postings/{jobPost}',
    [AdminJobPostController::class, 'destroy']
)
    ->withTrashed()
    ->name('admin.job-posts.destroy');

Route::get(
    '/admin/job-postings/{jobPost}',
    [AdminJobPostController::class, 'show']
)->name('admin.job-posts.show');

    /*
    |--------------------------------------------------------------------------
    | Administrator User Management Routes — JPW-15
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/users',
        [AdminUserController::class, 'index']
    )->name('admin.users.index');

    Route::patch(
    '/admin/users/{user}/deactivate',
    [AdminUserController::class, 'deactivate']
    )->name('admin.users.deactivate');


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
    | Edit Job Posting — JPW-8
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/employer/jobs/{jobPost}/edit',
        [JobPostController::class, 'edit']
    )->name('jobs.edit');

    Route::put(
        '/employer/jobs/{jobPost}',
        [JobPostController::class, 'update']
    )->name('jobs.update');

    /*
    |--------------------------------------------------------------------------
    | View Applicants — JPW-10
    |--------------------------------------------------------------------------
    */

    Route::get(
    '/employer/jobs/{jobPost}/applicants',
    [JobApplicationController::class, 'employerApplicants']
    )->name('employer.applicants.index');

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

    /*
    |--------------------------------------------------------------------------
    | View Application — JPW-5
    |--------------------------------------------------------------------------
    */

    Route::get(
    '/applications',
    [JobApplicationController::class, 'index']
    )->name('applications.index');

});