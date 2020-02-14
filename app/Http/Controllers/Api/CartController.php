<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use stdClass;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $product = Product::find($request->json('product_id'));
        
        if ($request->json('qty') > $product->stock) { 
            return response()->json(['status' => 401, 'data' => [], 'error' => "Product's stock not available."]);   
        }

        $cart = Cart::where('user_id',$request->user()->id)->first();

        if($cart) {

            $chck = Cart::where('user_id',$request->user()->id)
                    ->where('vendor_id',$request->json('vendor_id'))->get();

            if($chck->isEmpty()) {
                return response()->json(['status' => 401, 'data' => [], 'error' => 'Cart must contain same sellers items.']);
            } 
        }


        $validator = Validator::make($request->json()->all(), [
            'vendor_id'    => 'required',
            'user_id'      => 'required',
            'product_id'   => 'required',
            'qty'          => 'required',
            'price'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'data' => [], 'error' => $validator->errors()->all()]);
        }


        $vendor_id = $request->json('vendor_id');
        $user_id =  $request->json('user_id');
        $product_id = $request->json('product_id');
        $price = $request->json('price');
        $qty =  $request->json('qty');


        $entry = Cart::where(['product_id' => $product_id])->increment('qty', 1);
        if (!$entry) {
            $save =  Cart::create([
                'vendor_id'     => $vendor_id,
                'user_id'       => $user_id,
                'product_id'   => $product_id,
                'price'        => $price,
                'qty'          => $qty
            ]);
        }

        return response()->json(['status' => $this->successStatus, 'data' => true, 'error' => null]);
    }

    public function getCart(Request $request)
    {


        $cart =  DB::table('carts')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->join('users', 'users.id', '=', 'carts.vendor_id')
            ->where('carts.user_id',$request->user()->id)
            ->select(
                'carts.*',
                'users.name',
                'users.shop_name',
                'users.address',
                'products.name',
                'products.description',
                'products.price'
            )
            ->get();

        $cart->status = $this->successStatus;
        $cart->error = null;


        return new CartCollection($cart);
    }
}
