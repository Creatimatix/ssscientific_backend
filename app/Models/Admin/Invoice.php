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
        'quote_id',
        'invoice_no',
        'po_no',
        'freight',
        'status',
        'installation',
        'created_by',
        'pan_no',
        'address',
        'apt_no',
        'zipcode',
        'city',
        'state',
        'is_billing_address',
        'tax_invoice_number',
    ];

    protected $appends = ['shipto_address'];

    public static function invoiceNumber($type){

        $invoiceId = (SELF::latest()->value('id')+1);
        if($type == 1){
            $intial = "SSS/PI/".$invoiceId;
        }else{
            $latestInvId = self::whereNotNull('tax_invoice_number')->orderBy('tax_invoice_number', 'desc')->get()->first();
            if($latestInvId){
                $invoiceId = $latestInvId->tax_invoice_number + 1;
            }else{
                $invoiceId = 1;
            }
            $intial = "SSS/INV/".$invoiceId;
        }
        return [
            'invoiceNo' => $intial."/".getFinancialYear(),
            'incrementNo' => $invoiceId
        ];
    }

    public function quote(){
        return $this->belongsTo(Quote::class,'quote_id','id')->with('items')->with('user');
    }

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class,'po_no','id')->with('vendor');
    }


    public function getShiptoAddressAttribute() {
        $array = [
            $this->address,
            $this->apt_no,
            $this->city,
            $this->state,
            $this->zipcode,
        ];

        $array = array_filter($array);
        return implode(', ', $array);
    }
}
