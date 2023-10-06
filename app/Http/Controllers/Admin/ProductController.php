<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use Image;
class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category')
                    ->where('status', 1)
                    ->where('type', 0)
                    ->get()
                    ->all();
        return view('admin.products.index',[
            'products' => $products
        ]);
    }

    public function getProduct(Request $request){
        $productId = $request->get('id');
        $product = Product::where('id',$productId)->get()->first();
        $html =  view('admin.products.product',[
            'product' => $product
        ])->render();

        return response()->json([
            'htmlView' => $html,
            'statusCode' => 200
        ]);
    }

    public function getProducts(Request $request){
        $searchTerm = trim($request->get('term', ''));
        $page = trim($request->get('page', 1));
        $limit = 10;
        if ($page < 1) {
            $page = 1;
        }

        $currentPage = $page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $userType = [];
        $tblProducts = Product::getTableName();
        $source = Product::where($tblProducts.'.status', '=', 1);

        if ($searchTerm !== '' && strlen($searchTerm) > 0) {
            $source->where(function ($query) use ($searchTerm,$tblProducts) {
                    $query->where($tblProducts.'.name', 'LIKE', $searchTerm.'%')
                        ->orWhere($tblProducts.'.description', 'LIKE', $searchTerm . '%')
                        ->orWhere($tblProducts.'.features', 'LIKE', $searchTerm . '%')
                        ->orWhere($tblProducts.'.short_description', 'LIKE', $searchTerm . '%');
            });
        }
        $source->orderBy($tblProducts.'.name', 'ASC');

        $result = $source->paginate($limit, [$tblProducts.'.id',$tblProducts.'.name']);

        return response()->json($result);
    }

    public function addCartItem(Request $request){
        dd($request->all());
    }


    public function deleteProduct(Product $product){
        if($product){
            $product->delete();
            return redirect()->back()->with('productSuccessMsg',"Product deleted successfully.");
        }else{
            return redirect()->back()->with('productErrorMsg',"Product not found.");
        }
    }

    public function create(Request $request){
        $categories =  Category::where('status', 1)->get()->all();
        return view('admin.products.create',[
            'categories' => $categories
        ]);
    }

    public function store(Request $request){

        $product  = new Product();
        $product->name = $request->get('name');
        $product->sku = $request->get('sku');
        $product->id_category = $request->get('category');
        $product->sr_no = $request->get('sr_no');
        $product->pn_no = $request->get('pn_no');
        $product->hsn_no = $request->get('hsn_no');
        $product->slug = $request->get('slug');
        $product->sale_price = $request->get('sale_price');
        $product->short_description = $request->get('short_description');
        $product->description = $request->get('description');
        $product->status = $request->get('status');
        $product->features = 1;
        $product->is_featured = 1;
        $product->is_reusable = 0;
        if(array_key_exists('type', $request->all())){
            $product->type = $request->get('type', 1);
        }
        $product->save();

        if($request->hasFile('images'))
        {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);

                $productImage = new ProductImage();
                $productImage->id_product = $product->id;
                $productImage->image_name = $imageName;
                $productImage->save();
            }
        }

        if($product->id > 0){
            if(array_key_exists('type', $request->all())){
                return redirect()->route('accessories')->with('productSuccessMsg',"Accessories created successfully.");
            }
            return redirect()->route('products')->with('productSuccessMsg',"Product created successfully.");
        }else{
            if(array_key_exists('type', $request->all())){
                return redirect()->route('accessories')->with('productErrorMsg',"something went wrong.");
            }
            return redirect()->route('products')->with('productErrorMsg',"something went wrong.");
        }
    }

    public function edit(Request $request,$productId = null){
        $products = Product::where('id', $productId)->with('images')->get()->first();
        $categories =  Category::where('status', 1)->get()->all();
        return view('admin.products.edit',[
            'product' => $products,
            'categories' => $categories
        ]);
    }

    public function update(Request $request){

       $productId = $request->get('id_product');
       $product = Product::where('id',$productId)->get()->first();
       if($product){
            $product->name = $request->get("name");
            $product->sku = $request->get("sku");
            $product->id_category = $request->get("category");
            $product->sr_no = $request->get("sr_no");
            $product->pn_no = $request->get("pn_no");
            $product->hsn_no = $request->get("hsn_no");
            $product->slug = $request->get("slug");
            $product->short_description = $request->get("short_description");
            $product->description = $request->get("description");
            $product->sale_price = $request->get("sale_price");
            $product->status = $request->get("status");
            $product->features = 1;
            $product->is_reusable = 0;
            $product->save();

           if($request->hasFile('images'))
           {
               foreach ($request->file('images') as $image) {
                   $imageName = time() . '_' . $image->getClientOriginalName();
                   $image->move(public_path('images/products'), $imageName);

                   $productImage = new ProductImage();
                   $productImage->id_product = $product->id;
                   $productImage->image_name = $imageName;
                   $productImage->save();
               }
           }
           if($product->id > 0){
               return redirect()->back()->with('productSuccessMsg',"Product updated successfully.");
           }else{
               return redirect()->back()->with('productErrorMsg',"something went wrong.");
           }
       }
    }

    public function uploadImageToBucket(Request $request){
        $product_sku = $request->get('sku');
        $image = $request->get('image');
    }

    public function uploadImageToS3($image, $psku){
        $image = str_replace('\\', '', $image);
        $fileName= time().'.png';

        $s3  = Storage::disk(config('filesystems.cloud'));
        $env = config('app.env') == 'production' ? '' : '';
        $basePath = $env. 'products/'.$psku.'/';
        $filePath = $basePath.$fileName;

        $thumbPath = $basePath.'thumbs/'.$fileName;

        $img = Image::make($image)->resize(450, null, function ($constraint){
            $constraint->aspectRatio();
        });

        $s3->put($filePath, file_get_contents($image,'public'));
        $s3->put($thumbPath, (string)$img->encode('png', 90),'public');
    }
    public function uploadImageToGcp($image, $psku){
        $image = str_replace('\\', '', $image);
        $baseImage = base64_encode(file_get_contents($image));
        $pngImage = null;
        $fileName = time().'.png';

        $filePath = storage_path('app\\images\\', $fileName);
        $pngImage = $filePath.$fileName;
        $pngImage=$this->base64ToImage($baseImage,$pngImage);

        $s3 = Storage::disk(config('filesystems.cloud'));

        $env = config('app.en') == 'production'?'':'';

        $basePath = $env.'products/'.$psku.'/';
        $filePath = $basePath.$fileName;

        $thumbPath = $basePath.'thumbs/'.$fileName;

        $img = Image::make($pngImage)->resize(450, null, function ($constraint){
            $constraint->aspectRation();
        });

        $s3->put($filePath, file_get_contents($pngImage),'public');
        $s3->put($thumbPath, (string)$img->encode('png', 90), 'public');

        return $fileName;
    }

    function base64ToImage($base64_string, $output_file){
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);

        return $output_file;
    }

    function deleteProductImage(Request $request){
        $idImage = $request->get('id_image');
        $image = ProductImage::where('id', $idImage)->get()->first();
        if($image){
            $image->delete();
        }
        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'message' => 'Terms and Conditions updated successfully',
            'data' => $idImage,
        ], Response::HTTP_OK);
    }

    public function getAccessories(Request $request){

        $accessories = Product::with('category')
            ->where('status', 1)
            ->where('type', 1)
            ->get()
            ->all();

        if($request->ajax()){
            $itemId = $request->get('itemId');
            $html =  '';
            $url = route('product.additem');
            foreach($accessories as $accessory){
                $onclick = "itemlist.add(this, '$url' , '$accessory->sku')";
                $html .= "<tr>";
                $html .= "<td>$accessory->name</td>";
                $html .= "<td>$accessory->pn_no</td>";
                $html .= "<td>$accessory->hsn_no</td>";
                $html .= "<td><a href='javascript:void(0)' onclick='$onclick'><i class='fa fa-plus'></i></a></td>";
                $html .= "</tr>";
            }

            return \response()->json([
                'htmlView' => $html
            ]);
        }
        return view('admin.products.accessories',[
            'accessories' => $accessories
        ]);
    }

    public function createAccessories(Request $request){
        $categories =  Category::where('status', 1)->get()->all();
        return view('admin.products.create_accessories',[
            'categories' => $categories
        ]);
    }

    public function editAccessory(Request $request,$accessoryId = null){
        $accessories = Product::where('id', $accessoryId)->get()->first();
        $categories =  Category::where('status', 1)->get()->all();
        return view('admin.products.edit_accessories',[
            'accessory' => $accessories,
            'categories' => $categories
        ]);
    }
}
