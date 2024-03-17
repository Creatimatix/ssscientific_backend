<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends BaseModel
{
    use HasFactory;


    public static function purchaseOrderNumber(){
        $val = self::orderBy('id','desc')->first();
        $lastId =  $val ? $val->id : 1;
        return "SSS/P.O.".($lastId)."./FY ".getFinancialYear();
    }

    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id','id');
    }

    public function products(){
        return $this->hasMany(PurchaseOrderProduct::class,'purchase_order_id','id')->with('product');
    }

}
