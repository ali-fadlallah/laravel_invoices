@extends('layouts.master')
@section('css')
    {{-- <style>
        @media print {

            #btnPrint {

                display: none;
            }
        }
    </style> --}}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طباعه الفاتوره</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm" id="print">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتوره</h1>
                            <div class="billed-from">
                                <h6>BootstrapDash, Inc.</h6>
                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">معلومات الفاتوره</label>
                                <p class="invoice-info-row"><span>رقم الفاتوره</span>
                                    <span>{{ $invoice->invoice_number }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاصدار</span>
                                    <span>{{ $invoice->invoice_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاستحقاق</span>
                                    <span>{{ $invoice->due_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <span>{{ $invoice->section->section_name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">المنتج</th>
                                        <th class="tx-center">مبلغ التحصيل</th>
                                        <th class="tx-right">مبلغ العموله</th>
                                        <th class="tx-right">الاجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="tx-12">{{ $invoice->product }}</td>
                                        <td class="tx-center">{{ number_format($invoice->amount_collection, 2) }}
                                        </td>
                                        <td class="tx-right">{{ number_format($invoice->amount_commission, 2) }}</td>
                                        <td class="tx-right">
                                            {{ number_format($invoice->amount_commission + $invoice->amount_collection, 2) }}
                                        </td>
                                    </tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13"></label>
                                            <p></p>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">الاجمالي</td>
                                    <td class="tx-right" colspan="2">
                                        {{ number_format($invoice->amount_commission + $invoice->amount_collection, 2) }}
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">نسبه الضريبه ({{ $invoice->rate_vat }})</td>
                                        <td class="tx-right" colspan="2">{{ number_format($invoice->value_vat, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">قيمه الخصم</td>
                                        <td class="tx-right" colspan="2">{{ number_format($invoice->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبه</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">{{ number_format($invoice->total, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">
                        {{-- <a class="btn btn-purple float-left mt-3 mr-2" href="">
                            <i class="mdi mdi-currency-usd ml-1"></i>Pay Now
                        </a> --}}
                        <a href="#" id="btnPrint" onclick="onPrint()" class="btn btn-danger float-left mt-3 mr-2">
                            <i class="mdi mdi-printer ml-1"></i>طباعه الفاتوره
                        </a>
                        {{-- <a href="#" class="btn btn-success float-left mt-3">
                            <i class="mdi mdi-telegram ml-1"></i>Send Invoice
                        </a> --}}
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script>
        function onPrint() {

            $('#btnPrint').hide();
            var newstr = document.getElementById('print').innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = newstr;
            document.title = "The Invoice";
            window.print();
            document.body.innerHTML = oldstr;
            location.reload();
            // return false;
        }
    </script>
@endsection
