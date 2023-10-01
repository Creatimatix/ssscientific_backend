<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    use HasFactory;

    protected $appends = ['default_image'];

    public function getDefaultImageAttribute(){
        return $this->image;
    }
    public function image($isMultiple = true){
        return $this->hasOne(ProductImage::class, 'id_product','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'id_category','id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class, 'id_product', 'id');
    }
}
