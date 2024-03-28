<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCartItems;
use App\Models\Admin\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use Image;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category')
                    ->where('status', 1)
                    ->where('type', 0)
//                    ->orderBy('id', 'desc')
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
        $source = Product::where($tblProducts.'.status', '=', 1)->where($tblProducts.'.type', Product::TYPE_PRODUCT);

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
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name'),
            ],
            'sku' => 'required',
//            'category' => 'required|integer',
            'pn_no' => [
                'required',
                'max:255',
                Rule::unique('products', 'pn_no'),
            ],
            'hsn_no' => 'required',
            'sale_price' => 'required|numeric',
            'short_description' => 'required',
            'description' => 'required|string',
//            'status' => 'required',
            'images' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        try{
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
            $product->status = $request->get('status', 1);
            $product->features = 1;
            $product->is_featured = 1;
            $product->is_reusable = 0;
            if(array_key_exists('type', $request->all())){
                $product->type = $request->get('type', 1);
            }
            $product->save();

            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);

                $productImage = new ProductImage();
                $productImage->id_product = $product->id;
                $productImage->image_name = $imageName;
                $productImage->save();
            }

            if ($request->hasFile('document')) {
                $document = $request->file('document');
                $imageName = time() . '_' . $document->getClientOriginalName();
                $document->move(public_path('images/products/document'), $imageName);

                $productImage = new ProductImage();
                $productImage->id_product = $product->id;
                $productImage->image_name = $imageName;
                $productImage->type = 1;
                $productImage->save();
            }

            $modelname = $request->get('modelname');
            if(isset($modelname)){
                if(isset($modelname[0]) && $modelname[0] != null){
                    foreach($modelname as $key => $model){
                        $accessories  = new Product();
                        $accessories->name = $request->get('modelname')[$key];
                        $accessories->sku = $request->get('acc_sku')[$key];
//                    $accessories->sr_no = $request->get('acc_sr_no')[$key];
                        $accessories->pn_no = $request->get('acc_pn_no')[$key];
                        $accessories->hsn_no = $request->get('acc_hsn_no')[$key];
                        $accessories->sale_price = $request->get('acc_sale_price')[$key];
                        $accessories->type = 1;
                        $accessories->short_description = null;
                        $accessories->description = null;
                        $accessories->status = Product::PRODUCT_STATUS;
                        $accessories->features = 1;
                        $accessories->id_product = $product->id;
                        $accessories->save();
                        $key++;
                    }
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

        }catch (\Exception $e){
            if(array_key_exists('type', $request->all())){
                return redirect()->route('accessories')->with('productErrorMsg',"something went wrong.");
            }
            return redirect()->route('products')->with('productErrorMsg',"something went wrong.");
        }
    }

    public function edit(Request $request,$productId = null){
        $products = Product::where('id', $productId)->with('accessories')->with('images')->get()->first();
        $categories =  Category::where('status', 1)->get()->all();
        return view('admin.products.edit',[
            'product' => $products,
            'categories' => $categories
        ]);
    }

    public function update(Request $request){
        $productId = $request->get('id_product');
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name')->ignore($productId),
            ],
            'sku' => 'required',
//            'category' => 'required|integer',
            'pn_no' => [
                'required',
                'max:255',
                Rule::unique('products', 'pn_no')->ignore($productId),
            ],
            'hsn_no' => 'required',
            'sale_price' => 'required|numeric',
            'short_description' => 'required',
            'description' => 'required|string',
            'status' => 'required',
            'images' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

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

           if ($request->hasFile('images')) {
               $image = $request->file('images');
               $imageName = time() . '_' . $image->getClientOriginalName();
               $image->move(public_path('images/products'), $imageName);
               $productImage = new ProductImage();
               $productImage->id_product = $product->id;
               $productImage->image_name = $imageName;
               $productImage->save();
           }

           if ($request->hasFile('document')) {
               $document = $request->file('document');
               $imageName = time() . '_' . $document->getClientOriginalName();
               $document->move(public_path('images/products/document'), $imageName);
               $productImage = new ProductImage();
               $productImage->id_product = $product->id;
               $productImage->image_name = $imageName;
               $productImage->type = 1;
               $productImage->save();
           }

           $modelname = $request->get('modelname');
           if(isset($modelname)){
               Product::where('id_product', $product->id)->delete();
               foreach($modelname as $key => $model){
                   if(!empty($model)){
                       $accessories  = new Product();
                       $accessories->name = $request->get('modelname')[$key];
                       $accessories->sku = $request->get('acc_sku')[$key];
//                    $accessories->sr_no = $request->get('acc_sr_no')[$key];
                       $accessories->pn_no = $request->get('acc_pn_no')[$key];
                       $accessories->hsn_no = $request->get('acc_hsn_no')[$key];
                       $accessories->sale_price = $request->get('acc_sale_price')[$key];
                       $accessories->type = 1;
                       $accessories->short_description = null;
                       $accessories->description = null;
                       $accessories->status = Product::PRODUCT_STATUS;
                       $accessories->features = 1;
                       $accessories->id_product = $product->id;
                       $accessories->save();
                       $key++;
                   }
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
        $itemId = $request->get('itemId');
        $productItem = ProductCartItems::where('id', $itemId)->get()->first();
        $productId = $productItem->product_id;

        $accessories = Product::with('accessories')
            ->where('status', 1)
            ->where('type', 1)
            ->where('id_product', $productId)
            ->get()
            ->all();

        if($request->ajax()){

            $htmlView = view('admin.products.accessory_list', [
                'accessories' => $accessories,
                'itemId' => $itemId
            ])->render();

            return \response()->json([
                'htmlView' => $htmlView
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

    public function updateAccessoriesPaymentStatus(Request $request){
        $itemId = $request->get('itemId');
        $isPayable = $request->get('isPayable');

        $item = ProductCartItems::where('id', $itemId)->get()->first();

        if($item){
            $item->is_payable = $isPayable;
            $item->save();
        }

        return \response()->json([
            'statusCode' => 200,
            'message' => ($isPayable == 1)?'Accessories applied for payable':'Accessories applied for non payable'
        ]);
    }


    public function actionUpload(Request $request){
        if($request->get('action')=="uploadProduct") {
            $invalidSalesTaxZipcode = [];
            if($request->hasFile('import_file')) {
                ini_set('memory_limit', '-1');
                $count=0;
                $file = $request->file('import_file');
                if(in_array($file->getClientOriginalExtension(),array('xls','xlsx','csv'))) {
                    $filepath = $file->getRealPath();

                    $data = Excel::toArray([], $request->file('import_file'));
                    $data = array_slice($data[0], 1);
                    if (isset($data) && count($data) > 0) {
                        foreach ($data as $key => $value) {
                            $productName = isset($value[0])?$value[0]:null;
                            $categoryName = isset($value[1])?$value[1]:null;
                            $price = isset($value[2])?$value[2]:null;
                            $pnNo = isset($value[3])?$value[3]:null;
                            $hsnNo = isset($value[4])?$value[4]:null;
                            $sku = isset($value[5])?$value[5]:null;
                            $shortDesc = isset($value[6])?$value[6]:null;
                            $desc = isset($value[7])?$value[7]:null;


                            if(!empty($productName)){
                                $slug = slug($productName);
                                $product = Product::where('slug', $slug)->get()->first();
                                $category = Category::where('category_name', $categoryName)->get()->first();
                                if(!$product){
                                    $product = new Product();
                                }
                                if(!$category){
                                    $category = new Category();
                                }
                                if($product && $category->category_name != $categoryName) {
                                    $product = new Product();
                                }

                                $product->name = $productName;
                                $product->sku = $sku;
                                $product->slug = $slug;
                                $product->id_category = $category->id;
                                $product->pn_no = $pnNo;
                                $product->hsn_no = $hsnNo;
                                $product->short_description = $shortDesc;
                                $product->description = $desc;
                                $product->sale_price = $price;
                                $product->status = Product::PRODUCT_STATUS;
                                $product->save();
                            }
                        }
                        return redirect()->route('product.upload')->with('productUploadSuccessMsg', 'Product imported successfully.');
                    }
                }else{
                    return redirect()->back()->with('productUploadErrorMsg', 'Please upload excel formats only');
                }
            }else{
                return redirect()->back()->with('productUploadErrorMsg', 'Please select file to upload');
            }
        }
        return view('admin.products.upload');
    }
}
