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
    تفاصيل فاتورة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    <!-- row opened -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    الفاتورة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="row">رقم الفاتورة</th>
                                                            <th scope="row">تاريخ الاصدار</th>
                                                            <th scope="row">تاريخ الاستحقاق</th>
                                                            <th scope="row">القسم</th>
                                                            <th scope="row">المنتج</th>
                                                            <th scope="row">مبلغ التحصيل</th>
                                                            <th scope="row">مبلغ العمولة</th>
                                                            <th scope="row">الخصم</th>
															<th scope="row">قيمة الضريبة</th>
                                                            <th scope="row">نسبة الضريبة</th>
                                                            <th scope="row">الاجمالي مع الضريبة</th>
                                                            <th scope="row">ملاحظات</th>
															<th scope="row">الحالة الحالية</th>
                                                        </tr>
                                                    </thead>
													<tbody>
														<td>{{ $invoice->id}}</td>
														<td>{{ $invoice->invoice_number}}</td>
														<td>{{ $invoice->invoice_Date}}</td>
														<td>{{ $invoice->section->section_name }}</td>
														<td>{{ $invoice->products->product_name }}</td>
														<td>{{ $invoice->Amount_collection }}</td>
														<td>{{ $invoice->Amount_Commission }}</td>
														<td>{{ $invoice->discount }}</td>
														<td>{{ $invoice->value_vat}}</td>
														<td>{{ $invoice->rate_vat }}</td>
														<td>{{ $invoice->total }}</td>
														<td>{{ $invoice->note }}</td>
														<td>
                                                            @if ($invoice->value_status == 1) {{--  مدفوعة --}}
                                                            <td><span class="badge badge-pill badge-success">{{ $invoice->status }}</span></td>
                                                            @elseif($invoice->value_status == 2) {{--  غير مدفوعة --}}
                                                            <td><span class="badge badge-pill badge-danger">{{ $invoice->status }}</span></td>
                                                            @else
                                                            <td><span class="badge badge-pill badge-warning">{{ $invoice->status }}</span></td>
                                                            @endif
														</td>
													</tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>رقم الفاتورة</th>
                                                            <th>نوع المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفع</th>
                                                            <th>تاريخ الدفع </th>
                                                            <th>ملاحظات</th>
                                                            <th>تاريخ الاضافة </th>
                                                            <th>المستخدم</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

														@foreach ($invoice_details as $details)
															
                                                        <tr>
                                                            <td>{{ $details->id }}</td>
                                                            <td>{{ $details->invoice_number }}</td>
                                                            <td>{{ $invoice->products->product_name }}</td>
                                                            <td>{{ $invoice->section->section_name }}</td>
                                                            @if ($invoice->value_status == 1) {{--  مدفوعة --}}
                                                            <td><span class="badge badge-pill badge-success">{{ $invoice->status }}</span></td>
                                                            @elseif($invoice->value_status == 2) {{--  غير مدفوعة --}}
                                                            <td><span class="badge badge-pill badge-danger">{{ $invoice->status }}</span></td>
                                                            @else
                                                            <td><span class="badge badge-pill badge-warning">{{ $invoice->status }}</span></td>
                                                            @endif
                                                            <td>{{ $invoice->invoice_Date}}</td>
                                                            <td>{{ $invoice->note  }}</td>
                                                            <td>{{ $details->created_at }}</td>
                                                            <td>{{ auth()->user()->name }}</td>
                                                        </tr>
														@endforeach
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                @can('اضافة مرفق')
                                                    <div class="card-body">
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">اضافة مرفقات</h5>
                                                        <form method="post" action="" enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                    name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                    value="">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                    value="">
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
                                                    </div>
                                                @endcan
                                                <br>
                                                <div class="card card-statistics">
                                                    <div class="card-body">
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">اضافة مرفقات</h5>
                                                        <form method="post" action=""
                                                            enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                    name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                    value="">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                    value="">
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
                                                    </div>
                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($invoice_attachment as $attachment) 
                                                            <tr>
                                                                <td>{{ $attachment->id }}</td>
                                                                <td>{{ $attachment->file_name }}</td>
                                                                <td>{{ $attachment->Created_by }}</td>
                                                                <td>{{ $attachment->created_at }}</td>
                                                                <td colspan="2">

                                                                    <a class="btn btn-outline-success btn-sm"
                                                                        href="{{ route('view_file', ['invoice_number' => $invoice->invoice_number, 'file_name' => $attachment->file_name]) }}" 
                                                                        role="button"><iclass="fas fa-eye"></iclass=>&nbsp;
                                                                        عرض</a>

                                                                    <a class="btn btn-outline-info btn-sm" href=""
                                                                        role="button"><i
                                                                            class="fas fa-download"></i>&nbsp;
                                                                        تحميل</a>

                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#delete_file"
                                                                        data-id="{{ $attachment->id }}"
                                                                        data-file_name="{{ $attachment->file_name }}"
                                                                        data-invoice_number="{{ $attachment->invoice_number }}"
                                                                        >حذف</button>


                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
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
            </div>
            <!-- /div -->
        </div>

    </div>
    <!-- /row -->

    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_files',22) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق؟</h6>
                        </p>

                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div> <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    
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

   
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);

        })
    </script>
   

@endsection
