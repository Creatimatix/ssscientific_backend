<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    public $timestamps = false;
    protected $fillable = [
        'id_product',
        'image_name',
        'type', // 0 = image; 1=document
        'is_default',
    ];
}
