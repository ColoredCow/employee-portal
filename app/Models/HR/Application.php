<?php

namespace App\Models\HR;

use App\Events\HR\ApplicationCreated;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    protected $table = 'hr_applications';

    /**
     * Custom create method that creates an application and fires necessary events
     *
     * @param  array $attr  fillables to be stored
     * @return this
     */
    public static function _create($attr)
    {
        $application = self::create($attr);
        event(new ApplicationCreated($application));
        return $application;
    }

    /**
     * Set application status to rejected
     */
    public function reject()
    {
        $this->update(['status' => config('constants.hr.status.rejected.label')]);
    }

    /**
     * Set application status to in-progress
     */
    public function markInProgress()
    {
        $this->update(['status' => config('constants.hr.status.in-progress.label')]);
    }

    public function job()
    {
    	return $this->belongsTo(Job::class, 'hr_job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'hr_applicant_id');
    }

    public function applicationRounds()
    {
        return $this->hasMany(ApplicationRound::class, 'hr_application_id');
    }
}
