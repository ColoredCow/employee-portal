@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Create Invoice</h1>
    <br>
    <a class="btn btn-info" href="/finance/invoices">See all invoices</a>
    <br><br>
    <div class="card">
        <form action="/finance/invoices" method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="project_id">Project</label>
                        <select name="project_id" id="project_id" class="form-control" required="required">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="project_invoice_id">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                        @foreach (config('constants.finance.invoice.status') as $status => $display_name)
                            <option value="{{ $status }}">{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="sent_on">Sent on</label>
                        <input type="text" class="form-control date-field" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="sent_amount">Sent amount</label>
                        <input type="number" class="form-control" name="sent_amount" id="sent_amount" placeholder="Sent Amount" required="required" step=".01" min="0">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="paid_on">Paid on</label>
                        <input type="text" class="form-control date-field" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="paid_amount">Paid amount</label>
                        <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="Paid Amount" step=".01" min="0">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="invoice_file">Upload Invoice</label>
                        <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="comments">Comments</label>
                        <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
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
