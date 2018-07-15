@extends('layouts.app')

@section('content')
<div class="container">
    <h1>New volunteer application</h1>
    <br>

    @include('status', ['errors' => $errors->all()])

    <div class="card">
        <form action="" method="POST" id="volunteer_form">
            {{ csrf_field() }}
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Job</label>
                        <select class="form-control" name="job_title" id="job_title" value="{{ old('job_title') }}" required="required">
                            <option value="">Select Job</option>
                            @foreach($jobs ?? [] as $job)
                                <option {{ ($job->title == old('job_title') ? 'selected:selected' : '' ) }} value="{{ $job->title }}">{{ $job->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="phone" class="field-required">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required="required">
                    </div>
                </div>
            </div>

            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
