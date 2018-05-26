<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\Controller;
use App\Models\HR\Application;
use App\Models\HR\Round;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Models\HR\Job;
use App\Http\Requests\HR\ApplicationRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\HR\Application\JobChanged;
use App\Models\HR\ApplicationMeta;
use App\Mail\HR\Application\RoundNotConducted;

abstract class ApplicationController extends Controller
{
    abstract function getApplicationType();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = [
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $this->getApplicationType(),
            'job' => request()->get('hr_job_id')
        ];

        $applications = Application::with('applicant', 'job')
            ->applyFilter($filters)
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Input::except('page'));

        return view('hr.application.index')->with([
            'applications' => $applications,
            'status' => request()->get('status'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::findOrFail($id);
        $application->load(['job', 'job.rounds', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.round', 'applicationMeta']);

        $attr = [
            'applicant' => $application->applicant,
            'application' => $application,
            'timeline' => $application->applicant->timeline(),
            'interviewers' => User::interviewers()->get(),
            'applicantOpenApplications' => $application->applicant->openApplications(),
            'applicationFormDetails' => $application->applicationMeta()->formData()->first(),
        ];

        if ($application->job->type == 'job') {
            $attr['hasGraduated'] = $application->applicant->hasGraduated();
            $attr['internships'] = Job::isInternship()->latest()->get();
        }
        return view('hr.application.edit')->with($attr);
    }

    /**
     * Update the specified resource
     *
     * @param ApplicationRequest $request
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApplicationRequest $request, int $id)
    {
        $validated = $request->validated();
        $application = Application::findOrFail($id);
        $application->load('applicant');

        switch($validated['action']) {
            case config('constants.hr.application-meta.keys.change-job'):
                $changeJobMeta = $application->changeJob($validated);
                Mail::send(new JobChanged($application, $changeJobMeta));
                return redirect()->route('applications.internship.edit', $id)->with('status', 'Application updated successfully!');
                break;
            case 'round-not-conducted':
                $roundNotConductedMeta = ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => 'round-not-conducted',
                    'value' => json_encode([
                        'application_round_id' => $validated['application_round_id'],
                        'reason' => $validated['round_not_conducted_reason'],
                        'mail_subject' => $validated['round_not_conducted_mail_subject'],
                        'mail_body' => $validated['round_not_conducted_mail_body'],
                    ]),
                ]);
                Mail::send(new RoundNotConducted($application, $roundNotConductedMeta));
                return redirect()->back()->with('status', 'Application updated successfully!');
                break;
        }

        return redirect()->back()->with('No changes were done to the application. Please make sure your are submitting valid data.');
    }
}
