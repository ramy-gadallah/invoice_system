@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

{{-- لينك الباكيج بتاع الاشعارات  --}}
{{-- https://php-flasher.io/library/noty/ --}}
{{-- انتهاء --}}

<!-- اللى بيجى فوق عالشاشة 1 css كود ال  -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
{{-- انتهاء --}}

@endsection
@section('title')
قائمة الفواتير
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير المؤرشفة  </span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row opened -->
<div class="row row-sm">
    <div class="col-sm-6 col-md-4 col-xl-3 m-4">
        <a href="{{ route('invoices.create') }}" class="btn btn-outline-primary btn-block">اضافة فاتورة</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="example1" class="table key-buttons text-md-nowrap">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">رقم الفاتورة</th>
                        <th class="border-bottom-0">تاريخ الفاتورة</th>
                        <th class="border-bottom-0">تاريخ الاستحقاق</th>
                        <th class="border-bottom-0">المنتج</th>
                        <th class="border-bottom-0">القسم</th>
                        <th class="border-bottom-0">الخصم</th>
                        <th class="border-bottom-0">قيمة الضريبة</th>
                        <th class="border-bottom-0">نسبة الضريبة</th>
                        <th class="border-bottom-0"> الاجمالى</th>
                        <th class="border-bottom-0">الحالة </th>
                        <th class="border-bottom-0">ملاحظات </th>
                        <th class="border-bottom-0">العمليات </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }} </td>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->invoice_Date }}</td>
                        <td>{{ $invoice->due_date }}</td>
                        <td>{{ $invoice->products->product_name }}</td>
                        <td><a href="{{ route("invoices_details.edit",$invoice->id) }}">{{ $invoice->section->section_name }}</a></td>
                        <td>{{ $invoice->discount }}</td>
                        <td>{{ $invoice->value_vat }}</td>
                        <td>{{ $invoice->rate_vat }}</td>
                        <td>{{ $invoice->total }}</td>
                         @if ($invoice->value_status == 1) {{--  مدفوعة --}}
                        <td><span class="badge badge-pill badge-success">{{ $invoice->status }}</span></td>
                        @elseif($invoice->value_status == 2) {{--  غير مدفوعة --}}
                        <td><span class="badge badge-pill badge-danger">{{ $invoice->status }}</span></td>
                        @else
                        <td><span class="badge badge-pill badge-warning">{{ $invoice->status }}</span></td>
                        @endif
                        <td>{{ $invoice->note }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    العمليات
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item" data-invoice_id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}" href="#delete_invoice" data-toggle="modal" data-effect="effect-scale">
                                        <i class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                    </a>

                                    <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}"
                                        data-toggle="modal" data-target="#Restore_invoice"><i
                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;
                                            Restore
                                      </a>
                          
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal for Deleting Invoice -->
            <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">حذف الفاتورة</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('forceDeletePost.invoice',"test") }}" method="post" id="deleteInvoiceForm">
                            @csrf
                            <div class="modal-body"> 
                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                <input class="form-control" name="invoice_number" value="" id="invoice_number" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

           <!-- Modal for Restore Invoice -->  
            <div class="modal fade" id="Restore_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Restore الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{route('invoiceRestore',1) }}" method="post">
                            @csrf
                    </div>
                    <div class="modal-body">
                        هل انت متاكد من عملية Restore ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="">
    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تاكيد</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
             <!-- End Modal -->

    </div>
</div>
<!-- /row -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></scrip>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
{{-- <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script> --}}

<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

<script>
    $('#delete_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id= button.data('invoice_id')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    });
</script>
<script>
    $('#Restore_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id= button.data('invoice_id')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    });
</script>
@endsection
