<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Login;

class LoginController extends Controller
{

    public function dashboard(Request $request){
        return view('admin/dashboard');
    }

    public function register(){
        $data = array(
            'fname' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        );
        DB::table('admins')->insert($data);
    }

    public function login(){
        return view('admin/login');
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required'
        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'error' => true,
                'error_type' => 'form',
                'message' => 'Invalid request',
                'errors' => $validator->errors()->toArray(),
            ], 422);

        }else{

            $loginModel = new Login();
            $response = $loginModel->authenticateMethod($request);

            if(array_key_exists('error', $response)){
                return response()->json($response, 422);
            }

            return response()->json($response);

        }

    }    

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('owm/login');
    }
}
