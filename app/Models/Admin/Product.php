<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class,'id_category','id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class, 'id_product', 'id');
    }
}
