@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.volunteers.menu')
            <br><br>
        </div>
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-12">
            <h1>Volunteering Reports</h1>
        </div>
        <div class="col-md-12">
            <img src="/images/volunteer-reports-min.png" alt="volunteer reports" class="w-full">
        </div>
    </div>
    <div class="row">

    </div>
</div>
@endsection
