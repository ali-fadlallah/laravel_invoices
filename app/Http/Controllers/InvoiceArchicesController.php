<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\InvoiceArchices;
use Illuminate\Support\Facades\Crypt;

class InvoiceArchicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();

        return view('invoices.archiveinvoices', compact('invoices'));
    }

    public function backToInvoice(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        Invoices::onlyTrashed()->where('id', $id)->restore();

        return redirect()->route('invoice_index')->with("success", " تم استعاده الفاتوره بنجاح");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceArchices $invoiceArchices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceArchices $invoiceArchices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceArchices $invoiceArchices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $id = Crypt::decrypt($id);
        $invoice = Invoices::withTrashed()->where('id', $id)->first();

        $invoice->forcedelete();

        return back()->with("deleted", "تم حذف الفاتوره بنجاح");


    }
}