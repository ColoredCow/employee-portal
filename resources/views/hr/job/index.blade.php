@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @includeWhen($type == 'volunteer', 'hr.volunteers.menu')
    @includeWhen($type == 'recruitment', 'hr.menu')
    <br><br>
    <h1>{{ $type == 'volunteer' ? 'Projects' : 'Jobs' }}</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Total applicants</th>
        </tr>
        @foreach ($jobs as $job)
        <tr>
            <td>
                <a href="/hr/jobs/{{ $job->id }}/edit">{{ $job->title }}</a>
            </td>
            <td>
                {{ ucfirst($job->type) }}
            </td>

            <td>
            @if ($job->applications->count())
                <a href="{{ route('applications.' . $job->type . '.index') }}?hr_job_id={{$job->id }}">{{ $job->applications->count() }}</a>
            @else
                {{ $job->applications->count() }}
            @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{ $jobs->links() }}
</div>
@endsection
