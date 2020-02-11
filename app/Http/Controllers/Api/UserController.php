<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
 

class UserController extends Controller
{
    public $successStatus = 200;

    public function Signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        

        if ($validator->fails()) {
            return response()->json(['status'=>401,'data'=>[],'error' => $validator->errors()->all()]);
        }

        $input = $request->all();
        $user = new User();
        $user->name = $request->name;
        $user->role_id = 3;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->avatar = $request->avatar;

        if($user->save()) {
            $response  =  $user;
            $response->token =  $user->createToken('ecommerce')->accessToken;
            return response()->json(['status' => $this->successStatus, 'data' => $response, 'error' => null]);        
        } 
        
    }


    public function login(Request $request)
    { 
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $response  =  $user;
            $response->token =  $user->createToken('ecommerce')->accessToken;
            return response()->json(['status' => $this->successStatus, 'data' => $response, 'error' => null]);
        } else {
            return response()->json(['status' => 401,'error' => 'Invalid email or password'], 401);
        }
    }

    public function getVendors(Request $request)
    { 
        $User = User::where('role_id',2)->get();
        if ($User) { 
            $response  =  $User; 
            return response()->json(['status' => $this->successStatus, 'data' => $response, 'error' => null]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
