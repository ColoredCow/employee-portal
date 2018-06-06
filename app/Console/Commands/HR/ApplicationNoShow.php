<?php

namespace App\Console\Commands\HR;

use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ApplicationNoShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:no-show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set application status to no-show if an application round is not conducted 2 hours after scheduled time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applicationRounds = ApplicationRound::with('application')
                            ->whereNull('round_status')
                            ->whereDate('scheduled_date', '=', Carbon::today()->toDateString())
                            ->where('scheduled_date', '<=', Carbon::now()->subHours(config('constants.hr.no-show-hours-limit'))->toDateTimeString())
                            ->get();

        $subject = Setting::module('hr')->key('no_show_mail_subject')->first();
        $subject = $subject ? $subject->setting_value : null;
        $body = Setting::module('hr')->key('no_show_mail_body')->first();
        $body = $body ? $body->setting_value : null;

        foreach ($applicationRounds as $applicationRound) {
            $application = $applicationRound->application;
            if ($application->status != config('constants.hr.application-meta.keys.no-show')) {
                ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => config('constants.hr.status.no-show.label'),
                    'value' => json_encode([
                        'round' => $applicationRound->id,
                        'mail_subject' => $subject,
                        'mail_body' => $body,
                    ]),
                ]);
            }
        }
    }
}
