<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Application;
use App\Models\HR\Round;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.application.index')->with([
            'applications' => Application::filterByStatus(request()->get('status'))->appends(Input::except('page')),
            'status' => request()->get('status'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $job = Job::where('title', $validated['job_title'])->first();

        return Application::_create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'resume' => $validated['resume'],
            'phone' => isset($validated['phone']) ? $validated['phone'] : null,
            'college' => isset($validated['college']) ? $validated['college'] : null,
            'graduation_year' => isset($validated['graduation_year']) ? $validated['graduation_year'] : null,
            'course' => isset($validated['course']) ? $validated['course'] : null,
            'linkedin' => isset($validated['linkedin']) ? $validated['linkedin'] : null,
            'reason_for_eligibility' => isset($validated['reason_for_eligibility']) ? $validated['reason_for_eligibility'] : null,
            'hr_job_id' => $job->id,
            'status' => config('constants.hr.status.new.label'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        $application->load(['job.rounds', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.round']);
        $applicant = $application->applicant;

        return view('hr.application.edit')->with([
            'applicant' => $application->applicant,
            'application' => $application,
            'rounds' => Round::all(),
            'applicantOpenApplications' => $applicant->openApplications(),
            'interviewers' => User::interviewers()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
