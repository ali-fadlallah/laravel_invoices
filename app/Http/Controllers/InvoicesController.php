<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\User;
use App\Models\Invoices;
use App\Models\Sections;
use App\Notifications\InvoicesPushNotification;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\InvoiceCreated;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function indexDashboard()
    {

        $Totalinvoices = Invoices::sum('total');
        $TotalinvoicesUnPaid = Invoices::where('value_status', 2)->sum('total');
        $TotalinvoicesPaid = Invoices::where('value_status', 1)->sum('total');
        $TotalinvoicesPartPaid = Invoices::where('value_status', 3)->sum('total');

        $TotalinvoicesCount = Invoices::count();
        $TotalinvoicesUnPaidCount = Invoices::where('value_status', 2)->count();
        $TotalinvoicesPaidCount = Invoices::where('value_status', 1)->count();
        $TotalinvoicesPartPaidCount = Invoices::where('value_status', 3)->count();


        $TotalinvoicesUnPaidPersent = ($TotalinvoicesUnPaid / $Totalinvoices) * 100;
        $TotalinvoicesPaidPersent = ($TotalinvoicesPaid / $Totalinvoices) * 100;
        $TotalinvoicesPartPaidPersent = ($TotalinvoicesPartPaid / $Totalinvoices) * 100;


        $chartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->labels(['الفواتير المدفوعه', 'الفواتير الغير مدفوعه', 'الفواتير المدفوعه جزئياً'])
            ->datasets([
                [
                    'backgroundColor' => ['#28B284', '#F74F6B', '#F38746'],
                    'hoverBackgroundColor' => ['#28B284', '#F74F6B', '#F38746'],
                    'data' => [$TotalinvoicesPaidCount, $TotalinvoicesUnPaidCount, $TotalinvoicesPartPaidCount]
                ]
            ])
            ->options([]);


        $chartjs2 = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->labels(['الفواتير المدفوعه', 'الفواتير الغير مدفوعه', 'الفواتير المدفوعه جزئياً'])
            ->datasets([
                [
                    "label" => "الفواتير",
                    'backgroundColor' => ['#28B284', '#F74F6B', '#F38746'],
                    'data' => [round($TotalinvoicesPaidPersent, 2), round($TotalinvoicesUnPaidPersent, 2), round($TotalinvoicesPartPaidPersent, 2)]
                ]
            ])
            ->options([]);

        return view('dashboard', compact('Totalinvoices', 'TotalinvoicesUnPaid', 'TotalinvoicesPaid', 'TotalinvoicesPartPaid', 'TotalinvoicesCount', 'TotalinvoicesUnPaidCount', 'TotalinvoicesPaidCount', 'TotalinvoicesPartPaidCount', 'TotalinvoicesUnPaidPersent', 'TotalinvoicesPaidPersent', 'TotalinvoicesPartPaidPersent', 'chartjs', 'chartjs2'));
    }
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }


    public function index_paid()
    {
        $invoices = Invoices::where('value_status', 1)->get();
        return view('invoices.allpaidinvoices', compact('invoices'));
    }

    public function index_unpaid()
    {
        $invoices = Invoices::where('value_status', 2)->get();
        return view('invoices.uppaidinvoices', compact('invoices'));
    }

    public function index_part_paid()
    {
        $invoices = Invoices::where('value_status', 3)->get();
        return view('invoices.partpaidinvoices', compact('invoices'));

    }
    public function archive($id)
    {
        $id = Crypt::decrypt($id);

        $checkInvoice = Invoices::findOrFail($id);

        $checkInvoice->delete();

        return redirect()->route('indexarchive');

    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sections = Sections::all();
        return view('invoices.addInvoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        Invoices::create([

            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'discount' => $request->Discount,
            'amount_commission' => $request->Amount_Commission,
            'amount_collection' => $request->Amount_collection,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'notes' => $request->note,
            'user' => Auth::user()->name,


        ]);


        $invoice_id = Invoices::latest()->first()->id;

        InvoiceDetails::create([

            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'sections' => $request->Section,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
            'invoice_id' => $invoice_id

        ]);

        if ($request->has('pic')) {


            $invoice_id = Invoices::latest()->first()->id;

            $data = $request->validate([

                'pic' => 'image|mimes:png,jpeg,jpg,pdf',
            ]);

            $data['pic'] = Storage::putFile('invoiceImages', $data['pic']);


            InvoiceAttachments::create([

                'invoice_id' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'fileName' => $data['pic'],
                'Created_by' => Auth::user()->name,

            ]);

        }

        // $users = User::first();

        // Notification::send($users, new InvoiceCreated($invoice_id));


        $userSchema = User::first();

        Notification::send($userSchema, new InvoicesPushNotification($invoice_id));

        return back()->with("success", $request->invoice_number . " has been added successfflly");

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {

        $id = Crypt::decrypt($id);
        $checkInvoice = Invoices::findOrFail($id);
        $sections = Sections::all();

        return view('invoices.paidInvoices', compact('checkInvoice', 'sections'));

    }

    public function updateStatus(Request $request, $id)
    {
        //

        // dd($request);
        $id = Crypt::decrypt($id);
        $checkInvoice = Invoices::findOrFail($id);

        $request->validate([

            "status" => 'required',
            "payment_date" => 'required',
        ]);
        if ($request->status == "مدفوعه") {
            # code...

            $checkInvoice->update([

                'status' => $request->status,
                'payment_date' => $request->payment_date,
                'value_status' => 1,
            ]);

            InvoiceDetails::create([

                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'sections' => $request->Section,
                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
                'user' => Auth::user()->name,
                'invoice_id' => $id

            ]);

            return back()->with("success", $request->invoice_number . " has been updated successfflly");

        } else {
            # code...

            $checkInvoice->update([

                'status' => $request->status,
                'payment_date' => $request->payment_date,
                'value_status' => 3,
            ]);

            InvoiceDetails::create([

                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'sections' => $request->Section,
                'status' => $request->status,
                'value_status' => 3,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
                'user' => Auth::user()->name,
                'invoice_id' => $id

            ]);
            return back()->with("success", $request->invoice_number . " has been updated successfflly");

        }

        // $checkInvoice->update([

        //     'invoice_number' => $request->invoice_number,
        //     'invoice_date' => $request->invoice_Date,
        //     'due_date' => $request->Due_date,
        //     'product' => $request->product,
        //     'section_id' => $request->Section,
        //     'discount' => $request->Discount,
        //     'amount_commission' => $request->Amount_Commission,
        //     'amount_collection' => $request->Amount_collection,
        //     'rate_vat' => $request->Rate_VAT,
        //     'value_vat' => $request->Value_VAT,
        //     'total' => $request->Total,
        //     'notes' => $request->note,
        //     'user' => Auth::user()->name,

        // ]);

        // return back()->with("success", $request->invoice_number . " has been added successfflly");

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        //
        $id = Crypt::decrypt($id);
        $checkInvoice = Invoices::findOrFail($id);
        $sections = Sections::all();

        return view('invoices.editInvoices', compact('checkInvoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $id = Crypt::decrypt($id);
        $checkInvoice = Invoices::findOrFail($id);

        $checkInvoice->update([

            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'discount' => $request->Discount,
            'amount_commission' => $request->Amount_Commission,
            'amount_collection' => $request->Amount_collection,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'notes' => $request->note,
            'user' => Auth::user()->name,

        ]);

        return back()->with("success", $request->invoice_number . " has been added successfflly");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        $checkInvoice = Invoices::findOrFail($id);

        $checkattachments = InvoiceAttachments::where('invoice_id', $checkInvoice->id)->get();

        if ($checkattachments != null) {
            # code...
            foreach ($checkattachments as $value) {
                # code...
                Storage::delete($value->fileName);
            }
        }

        $checkInvoice->forcedelete();

        return back()->with("deleted", "تم حذف الفاتوره بنجاح");

    }

    public function getProducts($id)
    {

        $states = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($states);

    }
    public function print_invoice($id)
    {

        $id = Crypt::decrypt($id);
        $invoice = Invoices::where('id', $id)->first();

        // dd($invoice);

        return view('invoices.printinvoice', compact('invoice'));
    }

    public function markNotification(Request $request)
    {
        $userNotificationMakrAsRead = auth()->user()->unreadNotifications;


        if ($userNotificationMakrAsRead) {
            # code...
            $userNotificationMakrAsRead->markAsRead();
            return back();
        }


    }
    public function export()
    {
        return Excel::download(new InvoicesExport, now() . '.xlsx');
    }

}