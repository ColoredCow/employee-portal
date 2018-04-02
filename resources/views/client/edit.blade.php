@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Edit Client</h1>
    <br>
    <a class="btn btn-info" href="/clients">See all clients</a>
    <br><br>
    <div class="card">
        <form action="/clients/{{ $client->id }}" method="POST">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <span>Client Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ $client->name }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ $client->email }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ $client->phone }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name">Address</label>
                        <textarea name="address" id="address" rows="5" class="form-control" placeholder="Address">{{ $client->address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
