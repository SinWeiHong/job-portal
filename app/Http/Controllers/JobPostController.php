<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobPostController extends Controller
{
    /**
     * Display the create job posting page.
     */
    public function create(Request $request): View
    {
        /*
         * Only authenticated employer accounts may access
         * the create job posting page.
         */
        abort_unless(
            $request->user()?->role === 'employer',
            403,
            'Only employer accounts can create job postings.'
        );

        return view('jobs.create');
    }

    /**
     * Validate and store a new job posting.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
         * Prevent job seekers and other account types
         * from submitting new job postings.
         */
        abort_unless(
            $request->user()?->role === 'employer',
            403,
            'Only employer accounts can create job postings.'
        );

        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'location' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'employment_type' => [
                    'required',
                    'string',
                    'in:Full-time,Part-time,Contract,Internship,Temporary',
                ],

                'salary_min' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'salary_max' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'gte:salary_min',
                ],

                'application_deadline' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                ],

                'status' => [
                    'required',
                    'string',
                    'in:open,draft',
                ],

                'description' => [
                    'required',
                    'string',
                    'max:5000',
                ],

                'requirements' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],
            ],
            [
                'title.required' =>
                    'Please enter the job title.',

                'title.max' =>
                    'The job title must not exceed 150 characters.',

                'location.required' =>
                    'Please enter the job location.',

                'location.max' =>
                    'The job location must not exceed 150 characters.',

                'employment_type.required' =>
                    'Please select an employment type.',

                'employment_type.in' =>
                    'Please select a valid employment type.',

                'salary_min.numeric' =>
                    'The minimum salary must be a valid number.',

                'salary_min.min' =>
                    'The minimum salary cannot be negative.',

                'salary_max.numeric' =>
                    'The maximum salary must be a valid number.',

                'salary_max.min' =>
                    'The maximum salary cannot be negative.',

                'salary_max.gte' =>
                    'The maximum salary must be equal to or greater than the minimum salary.',

                'application_deadline.required' =>
                    'Please select an application deadline.',

                'application_deadline.date' =>
                    'Please enter a valid application deadline.',

                'application_deadline.after_or_equal' =>
                    'The application deadline cannot be earlier than today.',

                'status.required' =>
                    'Please select the job posting status.',

                'status.in' =>
                    'Please select a valid job posting status.',

                'description.required' =>
                    'Please enter the job description.',

                'description.max' =>
                    'The job description must not exceed 5000 characters.',

                'requirements.max' =>
                    'The job requirements must not exceed 5000 characters.',
            ]
        );

        JobPost::create([
            'employer_id' => $request->user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'requirements' => $validated['requirements'] ?? null,
            'location' => $validated['location'],
            'employment_type' => $validated['employment_type'],
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'application_deadline' =>
                $validated['application_deadline'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('jobs.create')
            ->with(
                'success',
                'The job posting has been created successfully.'
            );
    }
}