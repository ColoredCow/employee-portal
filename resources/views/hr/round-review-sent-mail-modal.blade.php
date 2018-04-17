<div class="modal fade hr_round_review" id="round_mail_{{ $applicantRound->id }}" tabindex="-1" role="dialog" aria-labelledby="round_mail_{{ $applicantRound->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="round_mail_{{ $applicantRound->id }}">Mail sent to {{ $applicantRound->applicant->email }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong class="d-block mb-1">Mail subject:</strong>
                <p class="bg-light p-3">{{ $applicantRound->mail_subject }}</p>
                <strong class="d-block mb-1">Mail body:</strong>
                <div class="bg-light p-3 mb-3 space-wrap">{!! $applicantRound->mail_body !!}</div>
                <strong class="d-block mb-1">Mail triggered by:</strong>
                <p class="bg-light p-3">{{ $applicantRound->mailSender->name }}</p>
                <strong class="d-block mb-1">Mail sent at:</strong>
                <p class="bg-light p-3">{{ $applicantRound->mail_sent_at }}</p>
            </div>
        </div>
    </div>
</div>
