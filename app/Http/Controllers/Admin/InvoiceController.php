<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Config;
use App\Models\Admin\Invoice;
use App\Models\Admin\Quote;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
   public function index(){

       $type = request()->get('type');
       if($type == Invoice::PROFORMA_INVOICE){
           $invoiceType = 'Proforma Invoice';
       }else{
           $invoiceType = 'Tax Invoice';
       }

       $invoices = Invoice::with('quote')->where('type', $type);
       if(Auth::user()->role_id != Role::ROLE_ADMIN){
           $invoices = $invoices->where('created_by', Auth::user()->id);
       }
       $invoices = $invoices->get()->all();

       return view('admin.invoices.index',[
            'invoices' => $invoices,
            'invoiceType' => $invoiceType
       ]);
   }
   public function create(Request $request){
        $type = $request->get('type');
        if($type == Invoice::PROFORMA_INVOICE){
           $invoiceType = 'Proforma Invoice';
        }else{
           $invoiceType = 'Tax Invoice';
        }
        return view('admin.invoices.create', [
            'type' => $type,
            'invoiceType' => $invoiceType
        ]);
   }

   public function store(Request $request){

       $request->validate([
           'quote_id' => 'required',
           'po_id' => 'required'
       ]);

       $type = $request->get('type');
       $invoice = new Invoice();
       $invoice->quote_id =  $request->get('quote_id');
       $invoice->invoice_no =  Invoice::invoiceNumber($type)['invoiceNo'];
       $invoice->po_no =  $request->get('po_id');
       $invoice->freight =  $request->get('freight');
       $invoice->installation =  $request->get('installation');
       $invoice->type = $type;
       if(!array_key_exists('isSameAsBillingAddress', $request->all())){
           $invoice->address =  $request->get('address');
           $invoice->apt_no =  $request->get('apt_no');
           $invoice->zipcode =  $request->get('zipcode');
           $invoice->city =  $request->get('city');
           $invoice->state =  $request->get('state');
       }else{
           $invoice->is_billing_address = true;
       }
       if($type == Invoice::INVOICE){
           $invoice->tax_invoice_number = Invoice::invoiceNumber($type)['incrementNo'];
       }
       $invoice->status =  $request->get('status');
       $invoice->created_by =  Auth::user()->id;
       $invoice->save();


//       if($invoice->id > 0){
//           $piInvoice = new Invoice();
//           $piInvoice->id_invoice = $invoice->id;
//           $piInvoice->quote_id =  $request->get('quote_id');
//           $piInvoice->invoice_no =  Invoice::invoiceNumber(1);
//           $piInvoice->po_no =  $request->get('po_id');
//           $piInvoice->freight =  $request->get('freight');
//           $piInvoice->installation =  $request->get('installation');
//           $piInvoice->type = 1;
//           $piInvoice->status =  $request->get('status');
//           $piInvoice->created_by =  Auth::user()->id;
//           $piInvoice->save();
//       }
       return redirect()->route('invoices',['type' => $type])->with("invoiceSuccessMsg",'Invoice create successfully.');
   }

   public function edit(Request $request,$invoice_id){
       $type = $request->get('type');
       $invoice = Invoice::where('id', $invoice_id)->with('quote')->with('purchaseOrder')->get()->first();
       if($type == Invoice::PROFORMA_INVOICE){
           $invoiceType = 'Proforma Invoice';
        }else{
           $invoiceType = 'Tax Invoice';
        }
       if($invoice){
           return view('admin.invoices.edit',[
               'model' => $invoice,
               'invoiceType' => $invoiceType,
               'type' => $type
           ]);
       }
   }

   public function update(Request $request){
       $type = $request->get('type');
       $invoice_id = $request->get('invoice_id');
       $invoice = Invoice::where('id', $invoice_id)->with('quote')->with('purchaseOrder')->get()->first();
       if($invoice){

           $invoice->quote_id =  $request->get('quote_id');
           $invoice->po_no =  $request->get('po_id');
           $invoice->freight =  $request->get('freight');
           $invoice->installation =  $request->get('installation');
           $invoice->status =  $request->get('status');
           if(!array_key_exists('isSameAsBillingAddress', $request->all())){
               $invoice->address =  $request->get('address');
               $invoice->apt_no =  $request->get('apt_no');
               $invoice->zipcode =  $request->get('zipcode');
               $invoice->city =  $request->get('city');
               $invoice->state =  $request->get('state');
               $invoice->is_billing_address = null;
           }else{
               $invoice->is_billing_address = true;
           }
           $invoice->save();

           return redirect()->route('invoices',['type' => $type])->with("invoiceSuccessMsg",'Invoice updated successfully.');
       }
   }

   public function destroy(Request $request,Invoice $invoice){
        if($invoice){
            $invoiceId = $invoice->id;
            if($invoice->delete()){
                Invoice::where('id_invoice', $invoiceId)->delete();
            }

            return redirect()->back()->with('invoiceSuccessMsg','Invoice Deleted successfully.');
        }
   }

    public function downloadInvoice(Request $request,$invoice_id){
        $type = $request->get('type');
        $invoiceType = $request->get('invoiceType');
        $layout = true;
        if ($type == 'html') {
            $layout = false;
        }

        $configs = Config::getVals(['IGST','CGST','SGST']);
        $invoice = Invoice::where('id', $invoice_id)->with('quote')->get()->first();
        $var = [
            'title' => 'Testing Page Number In Body',
            'layout' => $layout,
            'invoice' => $invoice,
            'model' => $invoice->quote,
            'configs' => $configs,
        ];
//        dd($invoice->quote);
        if($invoiceType == Invoice::INVOICE){
            $prefix='Invoice';
            $page = 'admin.pdf.invoice';
        }else{
            $prefix='Proforma Invoice';
            $page = 'admin.pdf.proforma_invoice';
        }

        if($type == 'pdf'){
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView($page, $var);
            return $pdf->download(strtoupper($prefix).'-'.time().'-' . $invoice->invoice_no . '.pdf');

        }else{
            return view($page, $var);
        }
    }

    public function deliveryNote(Request $request,$invoiceId){
        $html = '';
        $type = $request->get('type', 'pdf');

        $configs = Config::getVals(['GST_NO','PAN_NO']);

        $invoice = Invoice::where('id', $invoiceId)->with('quote')->get()->first();


        $layout = true;
        if ($type == 'html') {
            $layout = false;
        }
        $var = [
            'title' => 'Delivery Note',
            'layout' => $layout,
            'invoice' => $invoice,
            'quote' => $invoice->quote,
            'configs' => $configs,
        ];
        $page = 'admin.pdf.delivery_note';
        $prefix='DeliveryNote';

        if($type == 'pdf'){
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView($page, $var);
            return $pdf->download('DeliveryNote-'.$invoice->invoice_no . '.pdf');

        }else{
            return view($page, $var);
        }
    }

}
