@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Create Invoice</h1>
    {{-- <br> --}}
    {{-- <a class="btn btn-info" href="/hr/jobs">See all invoices</a> --}}
    <br><br>
    <div class="card">
        <form action="/finance/invoices" method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Invoice Title" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="project_id">Project</label>
                        <select name="project_id" id="project_id" class="form-control" required="required">
                            <option value="">Select Project</option>
                            <option value="1">ManageMyNGO</option>
                            <option value="2">Etherapydocs</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="project_invoice_id">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="name">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                            <option value="paid">Paid</option>
                            <option value="unpaid" selected="selected">Unpaid</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="sent_on">Sent on</label>
                        <input type="text" class="form-control" name="sent_on" id="sent_on" placeholder="dd/mm/yy" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="paid_on">Paid on</label>
                        <input type="text" class="form-control" name="paid_on" id="paid_on" placeholder="dd/mm/yy">
                    </div>
                </div>
                <br>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
