<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class Product extends BaseModel
{
    use HasFactory;

    protected $appends = ['default_image','default_document'];

    const PRODUCT_STATUS = 1;
    const TYPE_PRODUCT = 0;
    const TYPE_ACCESSORIES = 1;

    protected $fillable = ["name","sku","slug","id_category","pn_no","hsn_no","short_description","description","sale_price","status","power","housing","calibration","display","weighing_units","item_accessories","id_product","id_product","mpn","capacity","readability","pan_size","overall_dimensions","shipping_dimensions","weight","shipping_weight","company_name"];
    public function getDefaultImageAttribute(){
        return $this->image;
    }

    public function getDefaultDocumentAttribute(){
        return $this->documents;
    }
    public function image($isMultiple = true){
        return $this->hasOne(ProductImage::class, 'id_product','id')->where('type', 0)->orderBy('id', 'desc');
    }

    public function documents($isMultiple = true){
        return $this->hasOne(ProductImage::class, 'id_product','id')->where('type', 1)->orderBy('id', 'desc');
    }

    public function category(){
        return $this->belongsTo(Category::class,'id_category','id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class, 'id_product', 'id')->where('type' , 0);
    }

    public function accessories(){
        return $this->hasMany(Product::class,'id_product','id');
    }
}
