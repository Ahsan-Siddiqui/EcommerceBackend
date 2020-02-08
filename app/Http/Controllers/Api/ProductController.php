<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get(Request $request)
    {
        try {

            $products = Product::all();

            if ($products) {
                $response  =  $products;
                return response()->json(['status' => $this->successStatus, 'data' => $response, 'error' => null]);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 401);
        }
    }
}
