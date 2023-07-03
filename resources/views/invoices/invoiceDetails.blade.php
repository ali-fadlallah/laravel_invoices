@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection

@section('title')
    تفاصيل الفاتوره
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل فاتوره
                    @foreach ($invoice as $item)
                        {{ $item->invoice_number }}
                    @endforeach
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    @include('errors.errors')
    @include('errors.success')
    <div class="row row-sm">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style3">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-3">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                    class="fa fa-laptop"></i> تفاصيل الفاتوره </a></li>
                                        <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i>
                                                حالات الدفع </a></li>

                                        <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i>
                                                المرفقات </a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab11">

                                        <table class="table table-striped">

                                            @foreach ($invoice as $item)
                                                <tbody>

                                                    <tr>
                                                        <th scope="row">رقم الفاتوره</th>
                                                        <td>{{ $item->invoice_number }}</td>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <td>{{ $item->invoice_date }}</td>
                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                        <td>{{ $item->due_date }}</td>
                                                        <th scope="row">القسم</th>
                                                        <td>{{ $item->section->section_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">المنتج</th>
                                                        <td>{{ $item->product }}</td>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <td>{{ $item->amount_collection }}</td>
                                                        <th scope="row">مبلغ العموله</th>
                                                        <td>{{ $item->amount_commission }}</td>
                                                        <th scope="row">الخصم</th>
                                                        <td>{{ $item->discount }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">نسبه الضريبه</th>
                                                        <td>{{ $item->rate_vat }}</td>
                                                        <th scope="row">قيمه الضريبه</th>
                                                        <td>{{ $item->value_vat }}</td>
                                                        <th scope="row">الاجمالي بالضريبه</th>
                                                        <td>{{ $item->total }}</td>
                                                        <th scope="row">الحاله الحاليه</th>
                                                        <td>

                                                            @if ($item->value_status == 1)
                                                                <span
                                                                    class="badge bg-success text-white">{{ $item->status }}</span>
                                                            @elseif ($item->value_status == 2)
                                                                <span
                                                                    class="badge bg-danger text-white">{{ $item->status }}</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-warning text-white">{{ $item->status }}</span>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">السمتخدم</th>
                                                        <td>{{ $item->user }}</td>
                                                        <th scope="row">ملاحظات</th>
                                                        <td>{{ $item->notes }}</td>
                                                    </tr>
                                                </tbody>
                                            @endforeach

                                        </table>

                                    </div>

                                    <div class="tab-pane" id="tab12">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">رقم الفاتوره</th>
                                                    <th scope="col">نوع المنتج</th>
                                                    <th scope="col">القسم</th>
                                                    <th scope="col">حاله الدفع</th>
                                                    <th scope="col">تاريخ الدفع</th>
                                                    <th scope="col">ملاحظات</th>
                                                    <th scope="col">تاريخ الاضافه</th>
                                                    <th scope="col">اسم المستخدم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($theInvoiceDetails as $item)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $item->invoice_number }}</td>
                                                        <td>{{ $item->product }}</td>
                                                        <td>
                                                            @foreach ($invoice as $iteminvoice)
                                                                {{ $iteminvoice->section->section_name }}
                                                            @endforeach
                                                        </td>
                                                        <td>

                                                            @if ($item->value_status == 1)
                                                                <span
                                                                    class="badge bg-success text-white">{{ $item->status }}</span>
                                                            @elseif ($item->value_status == 2)
                                                                <span
                                                                    class="badge bg-danger text-white">{{ $item->status }}</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-warning text-white">{{ $item->status }}</span>
                                                            @endif

                                                        </td>

                                                        <td>NAN</td>
                                                        <td>{{ $item->note }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>{{ $item->user }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="tab-pane" id="tab13">

                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                        <h5 class="card-title">المرفقات</h5>

                                        <form action="{{ route('uploadattach') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" name="pic" class=" form-control d-inline"
                                                accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" required />

                                            <input type="hidden" name="invoiceNumbr" value="{{ $item->invoice_number }}">
                                            <input type="hidden" name="invoiceID" value="{{ $item->invoice_id }}">
                                            <button type="submit" class="btn btn-primary d-inline-block my-1">حفظ
                                                المرفق</button>
                                        </form>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">قام بالاضافه</th>
                                                    <th scope="col">تاريخ الاضافه</th>
                                                    <th scope="col">العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attachments as $attachment)
                                                    <tr>
                                                        <td>
                                                            {{ $attachment->Created_by }}
                                                        </td>
                                                        <td>
                                                            {{ $attachment->created_at }}
                                                        </td>
                                                        <td>

                                                            <a target="_blank"
                                                                href="{{ route('invoice_details_image', Crypt::encrypt($attachment->fileName)) }}">
                                                                <button type="button" class="btn btn-primary">
                                                                    عرض
                                                                </button>
                                                            </a>


                                                            <a
                                                                href="{{ route('invoice_details_delete', Crypt::encrypt($attachment->id)) }}">
                                                                <button type="button" class="btn btn-danger">
                                                                    حذف
                                                                </button>
                                                            </a>

                                                            <a
                                                                href="{{ route('invoice_details_download_image', Crypt::encrypt($attachment->fileName)) }}">
                                                                <button type="button" class="btn btn-warning">
                                                                    تحميل
                                                                </button>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
@endsection
