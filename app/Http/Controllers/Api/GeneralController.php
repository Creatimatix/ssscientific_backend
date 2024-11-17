<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
$id = 0;
class GeneralController extends Controller
{

    public function index()
    {
        $categories = Category::with('products')->with('childLevelCategories')->get();


        return response()->json($categories);
    }
    
	public function getProduct(Request $request, $pid = null){
		$product = Product::with(['category','images'])->where('id', $pid)->get()->first();
		$data = [];
		$status = Response::HTTP_OK;
		if($product){
			$data = $product;
		}else{
			$status = Response::HTTP_NOT_FOUND;
		}
		return response()->json([
			'status' => $status, 
			'product' => $product
		]);
	}

    function getCategory($cats, $parent_id = 0){

        $catName = '';
        foreach ($cats as $cat) {
            if (isset($cat->Title)) {
//echo "Cat: " . $cat->Title. ' - id => ' .++$id . ' - P_id => ' .$parent_id . "<br>";
//                echo "INSERT INTO `categories` (`category_name`, `id_parent`, `status`) VALUES ('".$cat->Title."', NULL, '1');". "<br>";
            }

            if (isset($cat->Products)) {
                $this->getCategory($cat->Products);
            } else {
                echo ' -> '.$cat->Name." - ".' -> '.$this->slugify($cat->Name);
//                INSERT INTO `products` (`id`, `id_category`, `sr_no`, `pn_no`, `hsn_no`, `sku`, `name`, `slug`, `short_description`, `description`, `features`, `status`, `sale_price`, `is_featured`, `is_reusable`, `created_at`, `updated_at`) VALUES (NULL, '2', 'SLL-1', 'PN1-1', 'HSN1-1', 'PSK', 'PP TEWS', 'pp-tews', 'adsaf', 'fadfdaf', '1', '1', '5000', '1', '0', NULL, NULL)
                $productDet = Product::where("name",'like',"%".$cat->Name."%")->get()->first();
                if($productDet){
                    $cat->Name = $cat->Name.'_'.$productDet->id;
                }
                $product = new Product();
                $product->id_category = 1;
                $product->name = $cat->Name;
                $product->slug = $this->slugify($cat->Name);
                $product->short_description = 'Short Desciption ';
                $product->description = 'Description';
                $product->sale_price = rand(5000,15000);
                $product->status = 1;
                $product->sku = "SSS_";
                $product->save();

                if($product){
                    $product->sku = "SSS_".$product->id;
                    $product->sr_no = $product->id;
                    $product->pn_no = "PN_NO".$product->id;
                    $product->hsn_no = "HSN_NO".$product->id;;
                    $product->save();
                }
            }
        }
    }

    function slugify($string) {
        $string = trim($string);
        $string = strtolower($string);
        $string = preg_replace('/\s+/', '-', $string);
        $string = preg_replace('/[^\w\-]+/', '', $string);
        $string = preg_replace('/\-+/', '-', $string);
        $string = preg_replace('/^-+/', '', $string);
        $string = preg_replace('/-+$/', '', $string);

        return $string;
    }

    function updateExistingProductInfo(){
        $path = public_path('ss_products.json');

        // Check if the file exists
        if (!File::exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Get the file contents
        $json = File::get($path);

        // Decode the JSON data
        $data = json_decode($json, true);

        foreach($data as $key => $product){
            $productDb = Product::where(['name' => $product['Name']])->get()->first();
            if($productDb) {
                if(isset($product['Image_URL']) && !empty($product['Image_URL'])){
                    $productDocument =new ProductImage();
                    $productDocument->id_product = $productDb->id;
                    $productDocument->image_name = $product['Image_URL'];
                    $productDocument->type = 0;
                    $productDocument->save();
                }
                if(isset($product['File_URL']) && !empty($product['File_URL'])){
                    $productDocument =new ProductImage();
                    $productDocument->id_product = $productDb->id;
                    $productDocument->image_name = $product['File_URL'];
                    $productDocument->type = 1;
                    $productDocument->save();
                }
            }
        }

        // Return the manipulated data as a response
        return response()->json(['messages' => 'data sync']);

    }
}


