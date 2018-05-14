<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrApplicantJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_applicant_job', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hr_applicant_id');
            $table->unsignedInteger('hr_job_id');
            $table->timestamps();
        });

        Schema::table('hr_applicant_job', function (Blueprint $table) {
            $table->foreign('hr_applicant_id')->references('id')->on('hr_applicants');
            $table->foreign('hr_job_id')->references('id')->on('hr_jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_applicant_job', function (Blueprint $table) {
            $table->dropForeign([
                'hr_applicant_id',
                'hr_job_id',
            ]);
        });
    }
}
