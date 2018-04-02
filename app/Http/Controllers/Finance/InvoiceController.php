<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\InvoiceRequest;
use App\Models\Finance\Invoice;
use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('finance.invoice.index')->with([
            'invoices' => Invoice::getList(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('finance.invoice.create')->with([
            'projects' => Project::select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InvoiceRequest $request)
    {
        $validated = $request->validated();
        $path = self::upload($validated['invoice_file']);
        $invoice = Invoice::create([
            'project_id' => $validated['project_id'],
            'project_invoice_id' => $validated['project_invoice_id'],
            'status' => $validated['status'],
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'paid_on' => $validated['paid_on'] ? DateHelper::formatDateToSave($validated['paid_on']) : null,
            'comments' => $validated['comments'],
            'file_path' => $path
        ]);

        return redirect('/finance/invoices');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return void
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        return view('finance.invoice.edit')->with([
            'invoice' => $invoice,
            'projects' => Project::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $validated = $request->validated();
        $updated = $invoice->update([
            'project_id' => $validated['project_id'],
            'project_invoice_id' => $validated['project_invoice_id'],
            'status' => $validated['status'],
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'paid_on' => $validated['paid_on'] ? DateHelper::formatDateToSave($validated['paid_on']) : null,
            'comments' => $validated['comments'],
        ]);
        return redirect('/finance/invoices/' . $invoice->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return void
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    /**
     * Upload invoice file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string    path of the uploaded file
     */
    protected static function upload(UploadedFile $file)
    {
        return $file->store(FileHelper::getCurrentStorageDirectory());
    }

    /**
     * Download invoice file.
     *
     * @param  string $year  uploaded year of the invoice file
     * @param  string $month uploaded month of the invoice file
     * @param  string $file  invoice file name
     * @return Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($year, $month, $file)
    {
        $file_path = FileHelper::getFilePath($year, $month, $file);
        if (Storage::exists($file_path)) {
            return Storage::download($file_path);
        }
    }
}
