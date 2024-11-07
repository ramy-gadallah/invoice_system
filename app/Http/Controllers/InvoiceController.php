<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachments;
use App\Models\Invoices_Detailes;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\addInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=Invoice::get();
        return view('invoices.invoices',compact('invoices'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getProducts($id){
        $products=DB::table("products")->where("section_id",$id)->pluck("product_name","id");

        return json_encode($products);
     }
    public function create()
    {
        $sections=Section::get();
        $products=Product::get();
        return view('invoices.add_invoice',compact('sections','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

             Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product_id' => $request->product_id,
            'section_id' => $request->section_id,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);


        $latestInvoice = Invoice::latest()->first();
        $invoices_id = $latestInvoice ? $latestInvoice->id : null;

       Invoices_Detailes::create([
            'invoice_id'=>$invoices_id,
            'invoice_number'=>$request->invoice_number,
            'product'=>$request->product_id,
            'section'=>$request->section_id,
            'status'=>'غير مدفوعة',
            'value_status'=>1,
            'note'=>$request->note,
            'user'=>(Auth::user()->name),

        ]);
        $file_extension=$request->pic->getClientOriginalExtension();
        $file_name =time().'.'.$file_extension;
        $path='image';
        $request ->pic->move($path,$file_name);

        $latestInvoice = Invoice::latest()->first();
        $invoices_id = $latestInvoice ? $latestInvoice->id : null;

             invoice_attachments::create([

            'invoice_number' => $request->invoice_number,
            'invoice_id' => $invoices_id,
            'file_name' => $file_name,
            'Created_by' => (Auth::user()->name),
        ]);
        session()->flash('info', 'تم اضافة الفاتورة بنجاح');
            return redirect()->route('invoices.index');


    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices=Invoice::where('id',$id)->first();
        $sections=Section::get();
        $products=Product::get();
        return view('invoices.edit_invoice',compact('invoices','sections','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $invoice=Invoice::where('id',$id)->first();
        // $invoice = Invoice::find($id);
        // $invoice->update([$request->all()]);
        // session()->flash('Edit', 'تم تعديل الفاتورة بنجاح');
        // return redirect()->back();

        $invoice=Invoice::findOrFail($id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->due_date,
            'product_id' => $request->product_id,
            'section_id' => $request->section_id,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'value_status'=>$request->value_status,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
            'value_status' => 1,

        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */




public function status_edit($id){
    $invoices=Invoice::find($id);
    $products=Product::get();
    $sections=Section::get();
    return view('invoices.status_update',compact('invoices','products','sections'));
}

public function status_update(Request $request ,$id){
    // dd($request->all());
    $invoice=Invoice::findOrFail($id);
    if($request->Status==' مدفوعة'){
        $invoice->update([
            'value_status' => 1,
            'status' => $request->status,
        ]);
        Invoices_Detailes::create([
            'id_Invoice' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'status' => $request->status,
            'Value_Status' => 1,
            'note' => $request->note,
            'Payment_Date' => $request->Payment_Date,
            'user' => (Auth::user()->name),
        ]);
    }
elseif($request->Status==' غير مدفوعة'){
    $invoice->update([
        'value_status' => 2,
        'status' => $request->status,
    ]);
    Invoices_Detailes::create([
        'id_Invoice' => $request->invoice_id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'Section' => $request->Section,
        'status' => $request->status,
        'Value_Status' => 2,
        'note' => $request->note,
        'Payment_Date' => $request->Payment_Date,
        'user' => (Auth::user()->name),
    ]);

}
    else{
        $invoice->update([
            'value_status' => 3,
            'status' => $request->status,
        ]);
        Invoices_Detailes::create([
            'invoice_id' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'status' => $request->status,
            'Value_Status' => 3,
            'note' => $request->note,
            'Payment_Date' => $request->Payment_Date,
            'user' => (Auth::user()->name),
        ]);
    session()->flash('success', 'تم تحديث الحالة بنجاح');
    return redirect()->route('invoices.index');
    }
}

public function invoices_paid(){
    $invoices=Invoice::where('value_status',1)->get();
    return view('invoices.invoices_paid',compact('invoices'));

}

public function invoices_unpaid(){
    $invoices=Invoice::where('value_status',2)->get();
    return view('invoices.invoices_unpaid',compact('invoices'));

}

public function invoices_partial(){
    $invoices=invoice::where('value_status',3)->get();
    return view('invoices.invoices_partial',compact('invoices'));
}

public function forceDeleteGet($id){     // حذف نهائيا من قائمة الفواتير route->get دا ب استخدام ال 
invoice::find($id)->forceDelete();
session()->flash('info', 'تم النقل الى الارشيف بنجاح');
return redirect()->route('invoices.index');
}

public function forceDeletePost(Request $request){   //من جدول الارشيف route->post دا ب استخدام ال 
  $invoice=Invoice::whereId($request->invoice_id)->withTrashed()->first();
  $invoice->forceDelete();
  session()->flash('info', 'تم حذف الفاتورة بنجاح');
  return redirect()->route('invoiceArchive');
  }

  public function softDeletes(Request $request){
    $invoices= Invoice::where('id',$request->invoice_id)->first()->delete();
    session()->flash('info', "تم softDelete الفاتورة بنجاح");
    return redirect()->back();
  }
  public function invoiceArchive(){
    $invoices=Invoice::onlyTrashed()->get();
    return view('invoices.archive_invoice',compact('invoices'));
}

public function invoiceRestore(Request $request){
  $invoice=Invoice::withTrashed()->find($request->invoice_id);
   $invoice->restore();
  session()->flash('info', "تم استعادة الفاتورة بنجاح");
  return redirect()->route('invoices.index');

}
}