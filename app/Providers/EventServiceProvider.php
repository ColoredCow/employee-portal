<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\HR\ApplicantCreated' => [
            'App\Listeners\HR\CreateApplicantRound',
            'App\Listeners\HR\AutoRespondApplicant',
        ],
        'App\Events\HR\ApplicantUpdated' => [
            'App\Listeners\HR\UpdateApplicantRound',
        ],
        'App\Events\HR\JobCreated' => [
            'App\Listeners\HR\CreateJobRounds',
        ],
        'App\Events\HR\JobUpdated' => [
            'App\Listeners\HR\UpdateJobRounds',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
