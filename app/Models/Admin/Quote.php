<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\User;
use Illuminate\Support\Facades\DB;

class Quote extends BaseModel
{
    use HasFactory;
    const QUOTE_DRAFT = 0;
    const QUOTE_REQUESTED = 1;
    const QUOTE_CREATED = 2;
    const PROPOSAL_CREATED = 3;
    const PROPOSAL_SENT = 4;
    const PROPOSAL_APPROVED = 5;
    const ORDER_PLACED = 6;
    const QUOTE_TEST = 7;
    const DOCUSIGN_SENT = 8;
    const AGREEMENT_SIGNED = 9;
    const STATUS_ACTIVE = 1;
    const ACTION_STATUS_TEST = 0;
    const ACTION_STATUS_CREATE = 1;
    const ACTION_STATUS_APPROVED = 2;
    const ACTION_STATUS_REJECTED = 3;
    const ACTION_STATUS_HOLD = 4;
    const CURRENCY_TYPES = [
        "INR" => "INR",
        "USD" => "USD",
        "EURO" => "EURO",
        "GBP" => "GBP",
    ];

    const ORDER_TYPE_TENDOR = 1;

    const INTER_STATE = 1;
    const INTRA_STATE = 2;

    protected $table = 'quotes';
//    protected $dateFormat = 'U';
    protected $fillable = [
        'quote_no',
        'token',
        'reference',
        'cust_id',
        'order_type',
        'tendor_no',
        'due_date',
        'phone_number',
        'email',
        'address',
        'apt_no',
        'gst_no',
        'zipcode',
        'city',
        'state',
        'billing_option',
        'billing_address',
        'billing_apt_no',
        'billing_zipcode',
        'billing_city',
        'billing_state',
        'relation',
        'reference_from',
        'referral',
        'referral_agency',
        'is_enquired',
        'currency_type',
        'notes',
        'status',
        'delivery_type',
        'action_type',
        'action_by',
        'action_at',
        'action_note',
        'created_at',
        'created_by',
        'updated_at',
        'total_title',
        'is_preview',
        'warranty_note',
    ];

    protected $appends = ['property_address','shipto_address'];

    public function user(){
        return $this->belongsTo(User::class,'cust_id','id');
    }

    public function getPropertyAddressAttribute() {
        $array = [
            $this->address,
            $this->apt_no,
            $this->city,
            $this->state,
            $this->zipcode,
        ];

        $array = array_filter($array);
        return implode(', ', $array).' '.$this->zip_code;
    }
    public function getShiptoAddressAttribute() {
        $array = [
            $this->billing_address,
            $this->billing_apt_no,
            $this->billing_city,
            $this->billing_state,
            $this->billing_zipcode,
        ];

        $array = array_filter($array);
        return implode(', ', $array);
    }

    public function items(){
        return $this->hasMany(ProductCartItems::class,'quote_id','id')->whereNull('item_id')
            ->with('accessories')
            ->with('product');
    }

    public static function getQuoteTotal($quoteId){
        $totalAmount = 0;
        $quote = SELF::where('id',$quoteId)->get()->first();
        if($quote){
            $items = ProductCartItems::select(DB::raw('sum(asset_value * quantity) as totalamount'))->with('accessories')->where("quote_id", $quote->id)->get()->all();

            if($items){
                foreach ($items as $item){
                    $totalAmount += $item->totalamount;
                    if($item->accessories){
                        foreach($item->accessories as $accessory){
                            if($accessory->is_payable){
                                $totalAmount += $accessory->asset_value;
                            }
                        }
                    }
                }
            }
            if($quote && $quote->discount > 0){
                $totalAmount = $totalAmount - $quote->discount;
            }
        }
        return [
            'totalAmount' => $totalAmount
        ];
    }
}
