<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Crypt;

class Login extends Model
{
    public function authenticateMethod($request){

        try {

            $admin = Admin::where('email', $request->email)->first();

            if($admin){

                if (Hash::check($request->password, $admin->password)) {

                    $adminData = [
                        'last_login' => now()
                    ];

                    Admin::where('email', $request->email)->update($adminData);

                    $request->session()->put('username', $admin->fname);
                    $request->session()->put('isAdmin', 'yes');
                    $request->session()->put('userType', $admin->role);
                    $request->session()->put('last_login', $admin->last_login);
                    $response = array(
                        'success' => true,
                        'userType' => $admin->role,
                        'message' => 'Login successful'
                    );

                    return $response;

                }else{

                    $response = array(
                        'error' => true,
                        'error_type' => 'login',
                        'message' => 'Incorrect Password'
                    );

                    return $response;
                }
                
            }else{
                $response = array(
                    'error' => true,
                    'error_type' => 'login',
                    'message' => 'User not found'
                );
                return $response;
            }

        } catch (\Exception $e) {
            return [
                'error' => true,
                'error_type' => 'database',
                'message' => 'Database connection error: ' . $e->getMessage(),
            ];
        }

    }
}
