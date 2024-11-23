<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ImageController;
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
    public function index(Request $request){
        if ($request->ajax()) {
            return $this->actionAjaxIndex($request);
        }

        $categories = Category::where(['status'=>Category::STATUS_ACTIVE])->get()->all();
        return view('admin.products.index',[
            'products' => [],
            'categories' => $categories
        ]);
    }

    public function actionAjaxIndex(Request $request){
        $id_category=$request->get('id_category');
        $columns = ['id','model_no','brand','status'];
        $sEcho = $request->get('sEcho', 1);
        $start = $request->get('iDisplayStart', 0);
        $limit = $request->get('iDisplayLength', 0);
        $colSort = $columns[(int) $request->get('iSortCol_0', 'name')];
        $colSortOrder = strtoupper($request->get('sSortDir_0', 'asc'));
        $searchTerm = trim($request->get('sSearch', ''));
        $page = ($start / $limit) + 1;
        if ($page < 1) {
            $page = 1;
        }
        $currentPage = $page;

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $product = Product::getTableName();
        $category = Category::getTableName();
        $columns = [
            $product.'.id',
            $product.'.name as model_no',
            $product.'.id_category',
            $category.'.category_name as brand',
            $product.'.short_description',
            $product.'.status'
        ];
        $products = Product::select($columns)->with('category')
            ->join($category, $product.'.id_category',$category.'.id')
            ->where($product.'.status', Product::PRODUCT_STATUS)
            ->where($product.'.type', 0);

        if($id_category!="All"){
            $products->where($product.'.id_category',$id_category);
        }

        if ($searchTerm !== '' && strlen($searchTerm) > 0) {
            $products->where(function ($query) use ($searchTerm, $product, $category) {
                $query->where($product . '.name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere($category . '.category_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        switch ($colSort) {
            default:
                $products->orderBy($colSort, $colSortOrder);
                break;
        }

        $products = $products->paginate($limit, $columns);
        $aaData = [];
        foreach ($products as $property) {
            $buttons = [
                'edit' => [
                    'label' => 'Edit',
                    'attributes' => [
                        'id' => $property->id.'_edit',
                        'href' => route('edit.product', ['id_product' => $property->id]),
                    ]
                ],
                'trash' => [
                    'label' => 'Delete',
                    'attributes' => [
                        'id' => $property->id.'_delete',
                        'href' => route('delete.product', ['product' => $property->id,'class' => 'ConfirmDelete']),
                        'class' => 'ConfirmDelete'
                    ]
                ]
            ];

            if(auth()->user()->role_id != \App\Models\Admin\Role::ROLE_ADMIN){
                unset($buttons['trash']);
            }

            $aaData[] = [
                'id' => $property->id,
                'model_no' => $property->model_no,
                'brand' => $property->brand,
                // 'short_description'=> $property->short_description,
                'status' => ($property->status == Product::PRODUCT_STATUS) ? 'Active' : 'Inactive',
                'controls' => table_buttons($buttons, false)
            ];
        }

        $total = $products->total();
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => $aaData
        );
        return response()->json($output);
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
        ini_set("max_execution_time", 1800);
        ini_set("max_input_time", -1);
        ini_set("post_max_size ", "100M");
        ini_set("upload_max_filesize ", "100M");
        ini_set("memory_limit ", "256M");
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name'),
            ],
//            'sku' => 'required',
//            'category' => 'required|integer',
//            'pn_no' => [
//                'required',
//                'max:255',
//                Rule::unique('products', 'pn_no'),
//            ],
//            'hsn_no' => 'required',
            'sale_price' => 'required|numeric',
            'short_description' => 'required',
            'description' => 'required|string',
//            'status' => 'required',
            'images' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        try{
            $product  = new Product();
            $product->name = $request->get('name');
//            $product->sku = $request->get('sku');
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
                $file = $request->file('images');

                $getFileName = explode(".",$file->getClientOriginalName());
                $imageName = isset($getFileName)?$getFileName[0].'_'.time().'.'.$getFileName[1]:time().'_'.$file->getClientOriginalName();
                $filePath  = 'products/images/'.$imageName;

                $controller = new ImageController($request);
                $controller->uploadToS3($file, $filePath);


                $productImage = new ProductImage();
                $productImage->id_product = $product->id;
                $productImage->image_name = $imageName;
                $productImage->save();
            }

            if ($request->hasFile('document')) {
                $document = $request->file('document');

                $getFileName = explode(".",$document->getClientOriginalName());
                $documentName = isset($getFileName)?$getFileName[0].'_'.time().'.'.$getFileName[1]:time().'_'.$document->getClientOriginalName();
                $documentPath  = 'products/documents/'.$documentName;

                $controller = new ImageController($request);
                $controller->uploadToS3($document, $documentPath);

                $productImage = new ProductImage();
                $productImage->id_product = $product->id;
                $productImage->image_name = $documentName;
                $productImage->type = 1;
                $productImage->save();
            }

            $modelname = $request->get('modelname');
            if(isset($modelname)){
                if(isset($modelname[0]) && $modelname[0] != null){
                    foreach($modelname as $key => $model){
                        $accessories  = new Product();
                        $accessories->name = $request->get('modelname')[$key];
//                        $accessories->sku = $request->get('acc_sku')[$key];
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
        ini_set("max_execution_time", 1800);
        ini_set("max_input_time", -1);
        ini_set("upload_max_filesize", "10M");
        ini_set("post_max_size", "10M");
        ini_set("memory_limit", "256M");
        $productId = $request->get('id_product');
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name')->ignore($productId),
            ],
//            'sku' => 'required',
//            'category' => 'required|integer',
//            'pn_no' => [
//                'required',
//                'max:255',
//                Rule::unique('products', 'pn_no')->ignore($productId),
//            ],
//            'hsn_no' => 'required',
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
//            $product->sr_no = $request->get("sr_no");
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
               $file = $request->file('images');

               $getFileName = explode(".",$file->getClientOriginalName());
               $imageName = isset($getFileName)?$getFileName[0].'_'.time().'.'.$getFileName[1]:time().'_'.$file->getClientOriginalName();
               $filePath  = 'products/images/'.$imageName;

               $controller = new ImageController($request);
               $controller->uploadToS3($file, $filePath, 'image');

               $productImage = new ProductImage();
               $productImage->id_product = $product->id;
               $productImage->image_name = $imageName;
               $productImage->save();
           }

           if ($request->hasFile('document')) {
               $document = $request->file('document');

               $getFileName = explode(".",$document->getClientOriginalName());
               $documentName = isset($getFileName)?$getFileName[0].'_'.time().'.'.$getFileName[1]:time().'_'.$document->getClientOriginalName();
               $documentPath  = 'products/documents/'.$documentName;

               $controller = new ImageController($request);
               $controller->uploadToS3($document, $documentPath, 'document');

               $productImage = new ProductImage();
               $productImage->id_product = $product->id;
               $productImage->image_name = $documentName;
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
//                       $accessories->sku = $request->get('acc_sku')[$key];
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
        ini_set("max_execution_time", 1800);
        ini_set("max_input_time", -1);
        ini_set("post_max_size ", "100M");
        ini_set("upload_max_filesize ", "100M");
        ini_set("memory_limit ", "256M");
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
                        $parentId = null;
                        foreach ($data as $key => $value) {
                            $productType = isset($value[1])?$value[1]:null;
                            $categoryName = isset($value[2])?$value[2]:null;
                            $productName = isset($value[0])?$value[0]:null;

                            $category = Category::where('category_name', $categoryName)->get()->first();
                            if(!$category && !empty($categoryName)){
                                $category = new Category();
                                $category->category_name = $categoryName;
                                $category->status = Category::STATUS_ACTIVE;
                                $category->save();
                            }

                            $price = 0;
                            $mpn = isset($value[3])?$value[3]:null;
                            $capacity = isset($value[4])?$value[4]:null;
                            $readability = isset($value[5])?$value[5]:null;
                            $shortDesc = isset($value[6])?$value[6]:null;
                            $desc = isset($value[7])?$value[7]:null;
                            $power = isset($value[8])?$value[8]:null;
                            $housing = isset($value[9])?$value[9]:null;
                            $calibration = isset($value[10])?$value[10]:null;
                            $display = isset($value[11])?$value[11]:null;
                            $weighing_units = isset($value[12])?$value[12]:null;
                            $pan_size = isset($value[13])?$value[13]:null;
                            $overall_dimensions = isset($value[14])?$value[14]:null;
                            $shipping_dimensions = isset($value[15])?$value[15]:null;
                            $weight = isset($value[16])?$value[16]:null;
                            $shipping_weight = isset($value[17])?$value[17]:null;
                            $accessories = isset($value[18])?$value[18]:null;

                            $pnNo = isset($value[25])?$value[25]:null;
                            $hsnNo = isset($value[26])?$value[26]:null;
                            $sku = isset($value[27])?$value[27]:null;
                            $companyName = isset($value[28])?trim($value[28]):null;
                            try{
                                if(!empty($productName) && $category){
                                    $slug = slug($productName);
                                    $product = Product::where('slug', $slug)->get()->first();
                                    if(!$product){
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
                                    if($productType == 'Parent'){
                                        $product->power = $power;
                                        $product->housing = $housing;
                                        $product->calibration = $calibration;
                                        $product->display = $display;
                                        $product->weighing_units = $weighing_units;
                                        $product->item_accessories = $accessories;
                                        $product->id_product = null;
                                    }else{
                                        $product->id_product = $parentId;
                                        $product->mpn = $mpn;
                                        $product->capacity = $capacity;
                                        $product->readability = $readability;
                                        $product->pan_size = $pan_size;
                                        $product->overall_dimensions = $overall_dimensions;
                                        $product->shipping_dimensions = $shipping_dimensions;
                                        $product->weight = $weight;
                                        $product->shipping_weight = $shipping_weight;

                                    }
                                    $product->company_name = $companyName;
                                    $product->save();

                                    if($productType == 'Parent'){
                                        $parentId = $product->id;
                                        $imageUrl = isset($value[19])?$value[19]:null;
                                        $documentUrl = isset($value[24])?$value[24]:null;
                                        if(!empty($imageUrl)){
                                            $documentPath  = 'products/images/';
                                            $controller = new ImageController($request);
                                            if (strpos($imageUrl, 'sharepoint') !== false){
                                                $imageUrl = $controller->storeSharePointFileToS3($imageUrl, $documentPath, 'image', $productName);
                                            }else{
                                                $imageUrl = $controller->storeImageFromUrlToS3($imageUrl, $documentPath, 'image', $productName);
                                            }
                                            if($imageUrl){
                                                $productImage = new ProductImage();
                                                $productImage->id_product = $parentId;
                                                $productImage->image_name = $imageUrl;
                                                $productImage->save();
                                            }
                                        }
                                        if(!empty($documentUrl)){
                                            $documentPath  = 'products/documents/';
                                            $controller = new ImageController($request);
                                            $imageUrl = $controller->storeDocumentFromUrlToS3($documentUrl, $documentPath, 'document', $productName);
                                            if($imageUrl){
                                                $productImage = new ProductImage();
                                                $productImage->id_product = $parentId;
                                                $productImage->image_name = $imageUrl;
                                                $productImage->type = ProductImage::TYPE_DOC;
                                                $productImage->save();
                                            }
                                        }
                                    }
                                }
                            }catch (\Exception $e){
                                dd($e->getMessage());
                                return redirect()->back()->with('productUploadErrorMsg', $e->getMessage());
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
