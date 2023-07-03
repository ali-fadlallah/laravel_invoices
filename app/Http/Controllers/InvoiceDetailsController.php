<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $id = Crypt::decrypt($id);

        $invoice = Invoices::where('id', $id)->get();

        $theInvoiceDetails = InvoiceDetails::where('invoice_id', $id)->get();

        $attachments = InvoiceAttachments::where('invoice_id', $id)->get();

        return view('invoices.invoiceDetails', compact('invoice', 'theInvoiceDetails', 'attachments'));
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
    public function show(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceDetails $invoiceDetails)
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
        $checkattachments = InvoiceAttachments::findOrFail($id);

        if ($checkattachments->fileName != null) {
            # code...
            Storage::delete($checkattachments->fileName);
        }

        $checkattachments->delete();

        return back()->with("success", " تم حذف المرفق بنجاح");

    }
    public function showImage($path)
    {
        //

        $path = Crypt::decrypt($path);

        return view('invoices.showImage', compact('path'));
    }
    public function downloadImage($path)
    {
        $path = Crypt::decrypt($path);

        return Storage::download($path);
    }
    public function uploadAttachment(Request $request)
    {

        // $id = Crypt::decrypt($id);
        // dd($id);

        if ($request->has('pic')) {

            // $checkCategory = InvoiceAttachments::findOrFail($id);

            // // $check = InvoiceAttachments::where('invoice_id', $id)->get();
            // $check = InvoiceAttachments::all();
            // dd($checkCategory);

            // $invoice_number = InvoiceAttachments::select('invoice_number')->where('invoice_id', $id)->get();
            // // dd($invoice_number);

            $data = $request->validate([

                'pic' => 'mimes:png,jpeg,jpg,pdf',
            ]);

            $data['pic'] = Storage::putFile('invoiceImages', $data['pic']);


            InvoiceAttachments::create([

                'invoice_id' => $request->invoiceID,
                'invoice_number' => $request->invoiceNumbr,
                'fileName' => $data['pic'],
                'Created_by' => Auth::user()->name,

            ]);

            return back()->with("success", "the attachment has been added successfflly");

        }


    }



}