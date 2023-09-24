<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProduct extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_products';

    protected $fillable = [
        'purchase_order_id',
        'id_product',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    // If a purchase order product belongs to a product:
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product')->with('images');
    }
}
