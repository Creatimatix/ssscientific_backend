<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    public $timestamps = false;

    protected $appends = ['image_url','document_url'];


    protected $fillable = [
        'id_product',
        'image_name',
        'type', // 0 = image; 1=document
        'is_default',
    ];

    public function getImageUrlAttribute()
    {
        $url =  url('/images/products/').'/'.$this->image_name;
        return ($this->type == 0) ? $url : '';
    }
    public function getDocumentUrlAttribute()
    {
        $url =  url('/images/products/document/').'/'.$this->image_name;
        return ($this->type == 1) ? $url : '';
    }
}
