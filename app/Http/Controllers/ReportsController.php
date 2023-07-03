<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    //
    public function CustomersReports()
    {

        $sections = Sections::all();
        return view('Reports.cutomersReports', compact('sections'));
    }
    public function indexinvoiceReports()
    {

        return view('Reports.invoiceReports');
    }
    public function Search_invoices(Request $request)
    {

        $rdio = $request->rdio;
        $type = $request->type;
        $invoice_number = $request->invoice_number;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        if ($type == "حدد نوع الفواتير" && $rdio == "1") {

            return back()->withErrors('برجاء تحديد نوع الفاتوره');
            # code...
        } else if ($rdio == "1") {
            # code...

            if ($start_at == '' && $end_at == '') {
                # code...

                $details = Invoices::where('status', $type)->get();

                return view('Reports.invoiceReports', compact('details', 'type'));

            } else {
                # code...

                $details = Invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('status', $type)->get();

                return view('Reports.invoiceReports', compact('details', 'type', 'start_at', 'end_at'));

            }


        } else {
            # code...

            $details = Invoices::where('invoice_number', $invoice_number)->get();

            return view('Reports.invoiceReports', compact('details', 'type'));

        }

    }

    public function Search_customers(Request $request)
    {

        $Section = $request->Section;
        $product = $request->product;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        $sections = Sections::all();

        if ($Section == null || $product == null) {
            # code...
            return back()->withErrors('اختيار الفسم او المنتج اجباري');

        } else {

            if ($start_at == '' && $end_at == '') {
                # code...

                $details = Invoices::where('section_id', $Section)->get();

                return view('Reports.cutomersReports', compact('details', 'sections'));

            } else {
                # code...

                $details = Invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('section_id', $Section)->get();

                return view('Reports.cutomersReports', compact('details', 'start_at', 'end_at', 'sections'));

            }

        }

    }

    public function getProducts($id)
    {

        $states = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($states);

    }

}