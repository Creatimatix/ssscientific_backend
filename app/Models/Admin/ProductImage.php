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

    const TYPE_IMG = 0;
    const TYPE_DOC = 1;
    protected $fillable = [
        'id_product',
        'image_name',
        'type', // 0 = image; 1=document
        'is_default',
    ];

    public function getImageUrlAttribute()
    {
//        $url =  url('/images/products/').'/'.$this->image_name;
        $url =  env('AWS_ATTACHEMENT_URL').'products/images/'.$this->image_name;
        return ($this->type == 0) ? $url : '';
    }
    public function getDocumentUrlAttribute()
    {
//        $url =  url('/images/products/document/').'/'.$this->image_name;
        $url =  env('AWS_ATTACHEMENT_URL').'products/documents/'.$this->image_name;
        return ($this->type == 1) ? $url : '';
    }
}
