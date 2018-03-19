@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Applicants</h1>
    <br>
    <a class="btn btn-primary" href="/hr/applicants/create"><i class="fa fa-plus"></i>&nbsp;&nbsp;New applicant</a>
    <a class="btn btn-info" href="/hr/jobs">See all jobs</a>
    <br>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Applied for</th>
            <th>Current Round</th>
            <th>Resume</th>
            <th>Date of application</th>
        </tr>
        <tr>
            <td>Vaibhav Rathore</td>
            <td>vaibhav@coloredcow.com<br>9090909090</td>
            <td>Laravel Developer</td>
            <td>Round 3: Detailed Tech</td>
            <td>https://linkedin.com</td>
            <td>26-08-2016</td>
        </tr>
        <tr>
            <td>Nishanth KD</td>
            <td>kd@coloredcow.com<br>9090909090</td>
            <td>Laravel Developer</td>
            <td>Round 1: Informal Call</td>
            <td>https://linkedin.com</td>
            <td>26-08-2016</td>
        </tr>
        <tr>
            <td>Pankaj Agarwal</td>
            <td>pankaj@coloredcow.com<br>9090909090</td>
            <td>Laravel Developer</td>
            <td>Round 4: Team interaction</td>
            <td>https://linkedin.com</td>
            <td>26-08-2016</td>
        </tr>
    </table>
</div>
@endsection
