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
        'App\Events\HR\ApplicantCreated' => [
            'App\Listeners\HR\CreateFirstApplicantRound',
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
