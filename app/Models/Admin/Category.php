<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'category_name',
        'id_parent',
        'status'
    ];

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'id_parent')->with('products');
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class,'id_parent','id');
    }

    public function products(){
        return $this->hasMany(Product::class,'id_category','id')->with('accessories')->whereNull('id_product');
    }

    public function childLevelCategories()
    {
        return $this->childCategories()->with('products')->with('childLevelCategories');
    }

}
