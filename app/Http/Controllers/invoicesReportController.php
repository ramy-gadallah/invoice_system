<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class invoicesReportController extends Controller
{
    
public function index(){
    return view('report.invoices_report');

}

public function invoicesSearch(Request $request){
    $radio=$request->input('radio');
    if($radio==1){
if($request->type && $request->start_at=='' && $request->end_at==''){
    $invoices=Invoice::select('*')->where('Status',$request->type)->get();
    // $type=$request->type;
    return view('report.invoices_report',compact('invoices'));
}
else{
    $start_at=date($request->start_at);
    $end_at=date($request->end_at); 
    $type=$request->type;

    $invoices=Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status',$request->type)->get();
    return view('report.invoices_report',compact('start_at','end_at','type','invoices'));
}
}
else {
$invoices=Invoice::select('*')->where('invoice_number',$request->invoice_number)->get();
return view('report.invoices_report',compact('invoices'));
}
}}


