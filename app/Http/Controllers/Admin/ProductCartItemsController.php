<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCartItems;
use App\Models\Admin\Quote;
use Illuminate\Http\Request;

class ProductCartItemsController extends Controller
{
    public function addCartItem(Request $request){
        $quote_id = $request->get('quote_id');
        $product_id = $request->get('productId');
        $quantity = $request->get('quantity');
        $assetValue = $request->get('assetValue');
        $originalAssetValue = $request->get('originalAssetValue');

        if(array_key_exists('itemId', $request->alL())){
            $isProductAdded = ProductCartItems::where(['quote_id'=>$quote_id,'product_id' => $product_id,'item_id' => $request->get('itemId')])->get()->count();
        }else{
            $isProductAdded = ProductCartItems::where(['quote_id'=>$quote_id,'product_id' => $product_id])->get()->count();
        }
        if($isProductAdded > 0){
            return response()->json([
                'message' => 'product already added.',
                'status' => false
            ]);
        }else{
            $cartItem = new ProductCartItems();
            $cartItem->quote_id = $quote_id;
            $cartItem->product_id = $product_id;
            $cartItem->quantity = $quantity;
            $cartItem->asset_value = $assetValue;
            $cartItem->original_asset_value = $originalAssetValue;
            if(array_key_exists('itemId', $request->alL())){
                $cartItem->item_id = $request->get('itemId');
            }
            $cartItem->save();
        }

        return response()->json([
            'message' => 'product added successfully.',
            'status' => true
        ]);
    }

    public function getItems(Request $request,$quote_id){
        $html = '';
        $items = ProductCartItems::where('quote_id',$quote_id)
                    ->with('product')
                    ->with('accessories')
                    ->whereNull('item_id')
                    ->get()
                    ->all();
        $quote = Quote::where('id',$quote_id)->get()->first();
        if($quote){
            $html =  view('admin.quotes.items',[
                'items' => $items,
                'quote' => $quote,
            ])->render();
        }

        return response()->json([
            'html' => $html,
            'status' => true
        ]);
    }
 public function previewItems(Request $request,$quote_id){
        $html = '';
        $items = ProductCartItems::where('quote_id',$quote_id)
                    ->with('product')
                    ->with('accessories')
                    ->whereNull('item_id')
                    ->get()
                    ->all();
        $quote = Quote::where('id',$quote_id)->get()->first();
        if($quote){
            $html =  view('admin.quotes.previewItems',[
                'items' => $items,
                'quote' => $quote,
            ])->render();
        }

        return response()->json([
            'html' => $html,
            'status' => true
        ]);
    }

    public function applyDiscount(Request $request){
        $quoteId = $request->get('quoteId');
        $discountAmount = $request->get('discountAmount');
        $quote = Quote::where('id',$quoteId)->get()->first();
        if($quote && !$quote->discount){
            $quote->discount = $discountAmount;
            $quote->save();

            return response()->json([
                'message' => 'discount added successfully.',
                'status' => true
            ]);
        }

        return response()->json([
            'message' => 'discount already applied.',
            'status' => false
        ]);
    }

    public function removeCartItem(Request $request){
        $itemId = $request->get('item');
        $productCartItem = ProductCartItems::where('id', $itemId)->get()->first();
        if($productCartItem){
            $productCartItem->delete();
            return redirect()->back()->with('quoteSuccessMsg','Cart item deleted successfully');
        }
        return redirect()->back()->with('quoteErrorMsg','Something went wrong.');
    }

    public function removeDiscount(Request $request,$quote_id){
        $quote = Quote::where('id', $quote_id)->get()->first();
        if($quote){
            $quote->discount = null;
            $quote->save();
            return redirect()->back()->with('quoteSuccessMsg','discount remove successfully');
        }
        return redirect()->back()->with('quoteErrorMsg','Something went wrong.');
    }
}
