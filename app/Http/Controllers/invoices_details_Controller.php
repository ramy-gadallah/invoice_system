<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachments;
use App\Models\Invoices_Detailes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class invoices_details_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $invoice=Invoice::where('id',"$id")->first();

        $invoice_details=Invoices_Detailes::where('invoice_id',"$id")->get();

        $invoice_attachment=invoice_attachments::where('invoice_id',"$id")->get(); 
        return view("invoices.details_invoices",compact('invoice','invoice_details','invoice_attachment'));

    }

    
       public function view_file($invoice_number, $file_name)
       {
           // Construct the full file path
        //    $file_path = Storage::disk('attachments')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
   
        //    // Check if the file exists
        //    if (!file_exists($file_path)) {  
        //        return abort(404, 'File not found.');
        //    }
   
        //    // Return the file as a response to be viewed in the browser
        //    return response()->file($file_path);
       }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $attachment=invoice_attachments::find($request->id);
         $attachment->delete();
         session()->flash('delete','تم حذف المرفق بنجاح');
         return redirect()->back();
    }
}
