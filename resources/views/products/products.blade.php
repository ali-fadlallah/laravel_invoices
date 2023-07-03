@extends('layouts.master')
@section('title')
    المنتجات
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                @include('errors.errors')

                @include('errors.success')

                <div>
                    <button class="btn btn-success" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"><i
                            class="typcn typcn-document-add"></i>
                        اضافه منتج
                    </button>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            <div>
                                                <button class="modal-effect btn btn-outline-primary"
                                                    data-id="{{ $product->id }}"
                                                    data-section_name="{{ $product->section->section_name }}"
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-description="{{ $product->description }}"
                                                    data-effect="effect-scale" data-toggle="modal" href="#modaldemo9">
                                                    تعديل
                                                </button>
                                                <button class="modal-effect btn btn-outline-danger mx-1"
                                                    data-id="{{ $product->id }}"
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-effect="effect-scale" data-toggle="modal" href="#modaldemo4">
                                                    حذف
                                                </button>
                                            </div>
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

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('product_store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">

                            <label for="product_name">اسم المنتج</label>
                            <input class=" form-control" type="text" name="product_name" id="product_name" required>

                            <label class="mt-2">القسم</label>
                            <select class=" form-control" name="section_id" id="">
                                <option value="0" selected disabled>-- حدد القسم --</option>
                                @foreach ($sections as $section)
                                    <option value={{ $section->id }}>{{ $section->section_name }}</option>
                                @endforeach
                            </select>

                            <label class="mt-2" for="txtadddesc">الملاحظات</label>
                            <textarea id="description" class="form-control" name="description" id="description" cols="30" rows="10"></textarea>

                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                                <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('product_update') }}" method="post"
                        autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <input class=" form-control" type="hidden" name="id" id="id">


                            <label for="product_name">اسم المنتج</label>
                            <input class=" form-control" type="text" name="product_name" id="product_name" required>

                            <label class="mt-2">القسم</label>
                            <select class="custom-select" name="section_name" id="section_name">
                                @foreach ($sections as $section)
                                    <option {{ $section->id }}>{{ $section->section_name }}</option>
                                @endforeach
                            </select>


                            <label for="description">الملاحظات</label>
                            <textarea id="description" class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                                <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo4">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>

                    <h4 class="tx-danger mg-b-20" id="product_name">هل انت متاكد من حذف ؟ </h4>

                    <form class="forms-sample" action="{{ route('product_delete') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input class=" form-control text-center mb-3" type="text" name="product_name"
                            id="product_name" readonly>
                        <input class=" form-control" type="hidden" name="id" id="id">
                        <button class="btn ripple btn-danger pd-x-25" type="submit">Continue
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var description = button.data('description')
            var section_name = button.data('section_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #section_name').val(section_name);
        });
        $('#modaldemo4').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_name = button.data('product_name')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endsection
