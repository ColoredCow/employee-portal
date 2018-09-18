@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-start row flex-wrap">
        @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view']))
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5 ">
                <a class="card-body no-transition" href="{{ route('hr') }}">
                    <br><h2 class="text-center">HR</h2><br>
                </a>
            </div>
        </div>
        @endif

        @can('finance_invoices.view')
        <div class="col-md-4">
            <div class= "card h-75 mx-4 mt-3 mb-5">
                <a class="card-body no-transition" href="/finance/reports?type=monthly">
                    <br><h2 class="text-center">Finance</h2><br>
                </a>
            </div>
        </div>
        @endcan

        @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
        <div class="col-md-4">
            <div class= "card h-75 mx-4 mt-3 mb-5">
                <a class="card-body no-transition" href="{{ route('knowledgecafe') }}">
                    <br><h2 class="text-center">KnowledgeCafe</h2><br>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasAnyPermission(['crm_talent.view', 'crm_client.view']))
        <div class="col-md-4">
            <div class="card h-75 mx-4 mt-3 mb-5">
                <a class="card-body no-transition" href="{{ route('crm') }}">
                    <br><h2 class="text-center">CRM</h2><br>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection
