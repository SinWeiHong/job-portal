<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the job seeker login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }
}