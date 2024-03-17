<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\PurchaseOrder;
use App\Models\Admin\PurchaseOrderProduct;
use App\Models\Admin\Quote;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PurchaseOrderController extends Controller
{
    public function index(){
        $purchaseOrder = PurchaseOrder::with('vendor')->get()->all();
        return view('admin.purchase_order.index',[
            'purchaseOrders' => $purchaseOrder
        ]);
    }

    public function create(){
        return view('admin.purchase_order.create');
    }

    public function store(Request $request){
//        dd($request->all());
        $poId = PurchaseOrder::purchaseOrderNumber();
        $request->request->add(['po_no' => $poId]);
        $validate = $request->validate([
            'po_no' => 'unique:purchase_orders,po_no,'.$poId,
            'vendor' => 'required',
            'attn_no' => 'required',
            'product' => 'required',
        ]);
        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->po_no = $poId;
        $purchaseOrder->vendor_id = $request->get('vendor');
        $purchaseOrder->attn_no = $request->get('attn_no');
        $purchaseOrder->status = $request->get('status', 1);
        $purchaseOrder->terms_n_condition = $request->get('term_n_condition');
        $purchaseOrder->save();

        if($purchaseOrder->id > 0){
            $products = $request->get('product');
            foreach($products as $product){
                $poProduct = new PurchaseOrderProduct();
                $poProduct->purchase_order_id = $purchaseOrder->id;
                $poProduct->id_product = $product;
                $poProduct->save();
            }
        }
        return redirect()->route('purchase.orders')->with("poSuccessMsg",'Purchase Order created successfully');
    }

    public function edit($purchaseOrderId){
        $purchaseOrder = PurchaseOrder::where('id',$purchaseOrderId)->with('vendor')->with('products')->get()->first();
        if($purchaseOrder){
            return view('admin.purchase_order.edit',[
                'model' => $purchaseOrder
            ]);
        }
    }

    public function update(Request $request,PurchaseOrder $purchaseOrder){
        $request->validate([
            'vendor' => 'required',
            'attn_no' => 'required',
            'status' => 'required',
            'product' => 'required',
        ]);

        if($purchaseOrder){
            $purchaseOrder->vendor_id = $request->get('vendor');
            $purchaseOrder->attn_no = $request->get('attn_no');
            $purchaseOrder->status = $request->get('status');
            $purchaseOrder->terms_n_condition = $request->get('term_n_condition');
            $purchaseOrder->save();
            if($purchaseOrder->id > 0){
                PurchaseOrderProduct::where('purchase_order_id',$purchaseOrder->id)->delete();
                $products = $request->get('product');
                foreach($products as $product){
                    $poProduct = new PurchaseOrderProduct();
                    $poProduct->purchase_order_id = $purchaseOrder->id;
                    $poProduct->id_product = $product;
                    $poProduct->save();
                }
            }

            return redirect()->back()->with("poSuccessMsg",'Purchase Order updated successfully');
        }
    }

    public function destroy(PurchaseOrder $purchaseOrder){
        if($purchaseOrder){
            $id = $purchaseOrder->id;
            if($purchaseOrder->delete()){
                PurchaseOrderProduct::where('purchase_order_id',$id)->delete();
            }
            return redirect()->route('purchase.orders')->with("poSuccessMsg",'Purchase Order deleted successfully');
        }
        return redirect()->route('purchase.orders')->with("poErrorMsg",'Purchase Order not found');
    }

    public function getPurchseOrder(Request $request){
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
        $tblPO = PurchaseOrder::getTableName();
        $source = PurchaseOrder::where([$tblPO.'.status' => 1]);


        if ($searchTerm !== '' && strlen($searchTerm) > 0) {
            $source->where(function ($query) use ($searchTerm,$tblPO) {
                if (preg_match('/^[0-9]+$/', $searchTerm)) {
                    $query->where($tblPO.'.id', '=', $searchTerm);
                } else {
                    $query->where($tblPO.'.po_no', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere($tblPO.'.attn_no', 'LIKE', $searchTerm . '%');
                }
            });
        }
        $source->orderBy($tblPO.'.id', 'ASC');
        $result = $source->paginate($limit, [$tblPO.'.id',$tblPO.'.po_no']);

        return response()->json($result);
    }

    public function downloadPurchaseOrder(Request $request,$po_id){
        $type = $request->get('type');
        $layout = true;
        if ($type == 'html') {
            $layout = false;
        }

        $purchaseOrder = PurchaseOrder::where('id', $po_id)->with('vendor')->with('products')->get()->first();

        $var = [
            'title' => 'Testing Page Number In Body',
            'layout' => $layout,
            'purchaseOrder' => $purchaseOrder
        ];
        $page = 'admin.pdf.purchase_order';
        $prefix='PurchaseOrder';

        if($type == 'pdf'){
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView($page, $var);
            return $pdf->download(strtoupper($prefix).'-'.time().'-' . $purchaseOrder->po_no . '.pdf');

        }else{
            return view($page, $var);
        }
    }

}
