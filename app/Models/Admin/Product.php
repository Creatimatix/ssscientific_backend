<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    use HasFactory;

    protected $appends = ['default_image','default_document'];

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
        return $this->hasMany(ProductImage::class, 'id_product', 'id');
    }


}
