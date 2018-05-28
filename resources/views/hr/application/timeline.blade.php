<div class="timeline mb-5">
    @foreach ($timeline as $item)
        <div class="timeline-container">
            <div class="content">
                @switch($item['type'])
                    @case('application-created')
                        @php
                            $application = $item['application'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($application->created_at)) }}</u></b><br>
                        <div>Applied for {{ $application->job->title }}</div>
                        @if ($application->autoresponder_subject && $application->autoresponder_body)
                            <span data-toggle="modal" data-target="#autoresponder_mail" class="modal-toggler-text text-primary">Auto-respond mail from system</span>
                            @include('hr.application.auto-respond', ['applicant' => $application->applicant, 'application' => $application])
                        @endif
                        @break

                    @case('round-conducted')
                        @php
                            $applicationRound = $item['applicationRound'];
                            $application = $item['application'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($applicationRound->conducted_date)) }}</u></b><br>
                        {{ $applicationRound->round->name }} for {{ $application->job->title }} conducted by {{ $applicationRound->conductedPerson->name }}<br>
                        @if ($applicationRound->mail_sent)
                            <span data-toggle="modal" data-target="#{{ $applicationRound->communicationMail['modal-id'] }}" class="{{ config("constants.hr.status.$applicationRound->round_status.class") }} modal-toggler">Communication mail</span><br>
                            @include('hr.communication-mail-modal', [ 'data' => $applicationRound->communicationMail ])
                        @endif
                        @break

                    @case(config('constants.hr.application-meta.keys.change-job'))
                        @php
                            $event = $item['event'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        Moved from {{ $event->value->previous_job }} to {{ $event->value->new_job }}<br>
                        <span data-toggle="modal" data-target="#{{ $event->communicationMail['modal-id'] }}" class="{{ config("constants.hr.status.rejected.class") }} modal-toggler">Communication mail</span><br>
                        @include('hr.communication-mail-modal', ['data' => $event->communicationMail])
                        @break

                    @case(config('constants.hr.application-meta.keys.round-not-conducted'))
                        @php
                            $event = $item['event'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        Round not conducted: {{ $event->value->round }}<br>
                        Reason: {{ config('constants.hr.application-meta.reasons-round-not-conducted.' . $event->value->reason) }}<br>
                        <span data-toggle="modal" data-target="#{{ $event->communicationMail['modal-id'] }}" class="{{ config("constants.hr.status.rejected.class") }} modal-toggler">Communication mail</span><br>
                        @include('hr.communication-mail-modal', ['data' => $event->communicationMail])
                        @break
                @endswitch
            </div>
        </div>
    @endforeach
</div>
