<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    const INVOICE = 0;
    const PROFORMA_INVOICE = 1;

    protected $fillable = [
        'quote_id','invoice_no','po_no','freight','status','installation','created_by','pan_no'
    ];

    public static function invoiceNumber($type){
        if($type == 1){
            $intial = "SSS/PI/";
        }else{
            $intial = "SSS/INV/";
        }
        return $intial.(SELF::latest()->value('id')+1)."/".getFinancialYear();
    }

    public function quote(){
        return $this->belongsTo(Quote::class,'quote_id','id');
    }

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class,'po_no','id')->with('vendor');
    }

}
