<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class CategoryController extends Controller
{
    public function get(Request $request)
    {
        try {

            $category = Category::where('vendor_id',$request->vendor_id)->get();

            if ($category) {
                $response  =  $category;
                return response()->json(['status' => $this->successStatus, 'data' => $response, 'error' => null]);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 401);
        }
    }
}
