<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class JobPostController extends Controller
{
    /**
     * Display the employer create job posting form.
     */
    public function create(): View
    {
        return view('jobs.create');
    }
}
