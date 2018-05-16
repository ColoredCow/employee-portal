@extends('layouts.app')

@section('content')

<div class="container" id="page_hr_applicant_edit">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.menu', ['active' => 'applications'])
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-3">
            @include('hr.application.timeline', ['applicant' => $applicant, 'application' => $application])
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline float-left">Applicant Details</div>
                    <div class="{{ config("constants.hr.status.$application->status.class") }} text-uppercase float-right card-status-highlight">{{ config("constants.hr.status.$application->status.title") }}</div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <b>Name</b>
                            <div>
                                {{ $applicant->name }}
                                @if ($applicant->linkedin)
                                    <a href="{{ $applicant->linkedin }}" target="_blank"><i class="fa fa-linkedin-square pl-1 fa-lg"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Applied for</b>
                            <div><a href="{{ $application->job->link }}" target="_blank">{{ $application->job->title }}</a></div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>Phone</b>
                            <div>{{ $applicant->phone ?? '-' }}</div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Email</b>
                            <div>{{ $applicant->email }}</div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>College</b>
                            <div>{{ $applicant->college ?? '-' }}</div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Course</b>
                            <div>{{ $applicant->course ?? '-' }}</div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>Resume</b>
                            <div>
                            @if ($applicant->resume)
                                <a href="{{ $applicant->resume }}" target="_blank"><i class="fa fa-file fa-2x"></i></a>
                            @else
                                –
                            @endif
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Graduation Year</b>
                            <div>{{ $applicant->graduation_year ?? '-' }}</div>
                        </div>
                        <div class="form-group col-md-12">
                            <b>Reason for eligibility</b>
                            <div>{{ $applicant->reason_for_eligibility ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($application->applicationRounds as $applicationRound)
                @php
                    $applicationReview = $applicationRound->applicationReviews->where('review_key', 'feedback')->first();
                    $applicationReviewValue = $applicationReview ? $applicationReview->review_value : '';
                @endphp
                <br>
                <form action="/hr/applications/rounds/{{ $applicationRound->id }}" method="POST" class="applicant-round-form">

                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="card">
                        <div class="card-header">
                            <div class="d-inline float-left">
                                {{ $applicationRound->round->name }}
                                <span title="{{ $applicationRound->round->name }} guide" class="modal-toggler-text text-muted" data-toggle="modal" data-target="#round_guide_{{ $applicationRound->round->id }}">
                                    <i class="fa fa-info-circle fa-lg"></i>
                                </span>
                            </div>
                            <div class="d-inline float-right">
                                @if ($applicationRound->round_status === config('constants.hr.status.confirmed.label'))
                                    <div class="text-success"><i class="fa fa-check"></i>{{ config('constants.hr.status.confirmed.title') }}</div>
                                @elseif ($applicationRound->round_status == config('constants.hr.status.rejected.label'))
                                    <div class="text-danger"><i class="fa fa-close"></i>{{ config('constants.hr.status.rejected.title') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="reviews[feedback]">Feedback</label>
                                    <textarea name="reviews[feedback]" id="reviews[feedback]" rows="6" class="form-control">{{ $applicationReviewValue }}</textarea>
                                </div>
                            </div>
                            @if ($applicationRound->round_status)
                                <div class="form-row float-right">
                                    <button type="button" class="btn btn-info btn-sm round-submit" data-action="update">Update feedback</button>
                                </div>
                            @endif
                        </div>
                        @if (! $applicationRound->round_status)
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <h6 class="m-0">Move to:&nbsp;</h6>
                                <select name="next_round" id="next_round" class="form-control w-50">
                                @foreach($application->job->rounds as $round)
                                    <option value="{{ $round->id }}">{{ $round->name }}</option>
                                @endforeach
                                </select>
                                <button type="button" class="btn btn-success ml-2 round-submit" data-action="confirm">GO</button>
                                @if ($applicantOpenApplications->count() > 1)
                                    <button type="button" class="btn btn-outline-danger ml-2" data-toggle="modal" data-target="#application_reject_modal">Reject</button>
                                @else
                                    <button type="button" class="btn btn-outline-danger ml-2 round-submit" data-action="reject">Reject</button>
                                @endif
                            </div>
                            @if ($applicantOpenApplications->count() > 1)
                                @include('hr.application.rejection-modal', ['currentApplication' => $application, 'allApplications' => $applicantOpenApplications ])
                            @endif
                        </div>
                        @elseif ($applicationRound->round_status === config('constants.hr.status.rejected.label') || !$applicationRound->mail_sent)
                        <div class="card-footer">
                            @if ($applicationRound->round_status === config('constants.hr.status.rejected.label'))
                                <div class="d-inline-flex align-items-center w-75">
                                    <h6 class="m-0">Move to:&nbsp;</h6>
                                    <select name="next_round" id="next_round" class="form-control w-50">
                                    @foreach($application->job->rounds as $round)
                                        <option value="{{ $round->id }}">{{ $round->name }}</option>
                                    @endforeach
                                    </select>
                                    <button type="button" class="btn btn-success ml-2 round-submit" data-action="confirm">GO</button>
                                </div>
                            @endif
                            @if (!$applicationRound->mail_sent)
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#round_{{ $applicationRound->id }}">Send mail</button>
                            @endif
                        </div>
                        @endif
                    </div>
                    <input type="hidden" name="action" value="updated">
                </form>
                @include('hr.round-guide-modal', ['round' => $applicationRound->round])
                @includeWhen($applicationRound->round_status && !$applicationRound->mail_sent, 'hr.round-review-mail-modal', ['applicantRound' => $applicationRound])
            @endforeach
        </div>
    </div>
</div>
@endsection
