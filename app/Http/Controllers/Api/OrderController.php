<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function createOrder(Request $request)
   {

      $cart = Cart::with('product')->where('user_id', $request->user()->id)->get();
      $sum = Cart::where('carts.user_id', $request->user()->id)->sum('price');
      

      $batch = [];


      $order = new Order();
      $order->vendor_id = $request->vendor_id;
      $order->user_id = $request->user()->id;
      $order->ordernum = uniqid();
      $order->total_amount =  $sum;
      $order->address = $request->user()->address;
      $order->customer_name = $request->user()->name;
      $order->order_status = 'Pending';
      $order->save();

      if (!empty($cart)) {
         foreach ($cart as $key => $value) {

            $batch[$key]['order_id'] = $order->id;
            $batch[$key]['product_name'] = $value->product->name;
            $batch[$key]['product_price'] = $value->price;
            $batch[$key]['qty'] = $value->qty;
         }
      }

      if(!empty($batch)) {
         $response = OrderItem::insert($batch);
      }

      


      if ($response) {
         Cart::where('user_id', $request->user()->id)->delete();
         return response()->json([
            'status' => $this->successStatus,
            'data' => $response, 'error' => null
         ]);
      }
   }
}
