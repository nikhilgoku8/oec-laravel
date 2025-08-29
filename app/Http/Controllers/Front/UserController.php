<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\CartItem;
use App\Models\Admin\Order;
use App\Models\Admin\OrderProduct;
use Illuminate\Support\Facades\Validator;
use Mail;
use Carbon\Carbon;
use App\Mail\PasswordResetOtpMail;
use App\Mail\SignupMail;
use App\Mail\ProductEnquiryMail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function sendOtpViaEmail(Request $request)
    {
        try {

            $validated = $request->validate([
                'email' => 'required|email'
            ]);

            $email = $validated['email'];

            // Block OTP for locked Users
            $user = User::where('email', $email)->first();
            if($user && $user->is_locked == 1){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => 'This account is locked contact admin.',
                ]);
            }

            // Check rate limiting
            if (session()->has('otp_last_sent_at')) {
                $diff = abs(now()->diffInSeconds(session('otp_last_sent_at')));
                    // dd($diff);
                if ($diff < 120) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'request_otp' => 'Please wait before requesting another OTP.',
                    ]);
                }
            }

            // Check if OTP exists and still valid
            if (
                session()->has('otp') &&
                ( session()->has('otp_email') && session('otp_email') == $email ) &&
                session()->has('otp_expires_at') &&
                now()->lessThan(session('otp_expires_at'))
            ) {
                $otp = session('otp');
            } else {
                // Generate new OTP
                $otp = rand(100000, 999999);

                session([
                    'otp' => $otp,
                    'otp_expires_at' => now()->addMinutes(10),
                    'otp_email' => $email,
                ]);
            }

            // Send OTP email
            Mail::to($email)->send(new PasswordResetOtpMail($otp));

            // Update last sent timestamp
            session(['otp_last_sent_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'OTP Sent',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }

    public function testOtpMail($otp='')
    {
        $otp = 123465;
        Mail::to('nikhilgoku8@gmail.com')->send(new PasswordResetOtpMail($otp));
    }
    
    public function register(Request $request)
    {

        try {

            $rules = [
                'fname'=>'required',
                'lname'=>'required',
                'company_name'=>'required',
                'phone'=>'nullable',
                'email'=>'required|email|unique:users,email',
                'otp'=>'required|numeric|digits:6',
                'role'=>'required',
                'password'=> 'bail|required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password'=> 'required|same:password',
                'accept_terms'=>'required'
            ];

            $messages = [
                'password.regex' => 'Must include uppercase, lowercase, number and special character.'
            ];

            $attributes = [
                'fname'=>'First Name',
                'lname'=>'Last Name',
                'company_name'=>'Company Name',
                'email'=>'Email',
                'otp'=>'OTP',
                'role'=>'Role',
                'password'=> 'Password',
                'confirm_password'=> 'Confirm Password',
                'accept_terms'=>'Terms'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            if(session('otp') != $request->otp){
                $validator->getMessageBag()->add('otp', 'OTP does not match');
                throw new \Illuminate\Validation\ValidationException($validator);
            }elseif (session('otp_email') !== $request->email) {
                $validator->getMessageBag()->add('email', 'Email must match OTP sent email');
                throw new \Illuminate\Validation\ValidationException($validator);
            }elseif (session('otp_expires_at') < now()) {
                $validator->getMessageBag()->add('otp', 'OTP Expired');
                throw new \Illuminate\Validation\ValidationException($validator);
            }
            
            $data = array(
                'fname' => $request->fname,
                'lname' => $request->lname,
                'billing_company' => $request->company_name,
                'shipping_company' => $request->company_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'last_password_changed' => now(),
                'registered_at' => now(),
                'created_by' => $request->fname.' '.$request->lname,
                'updated_by' => $request->fname.' '.$request->lname
            );

            User::create($data);

            $userName = $request->fname.' '.$request->lname;

            Mail::to($request->email)->send(new SignupMail($userName));

            $response = array(
                'success' => true,
                'message' => 'Record created',
                'class' => 'alert alert-success'
            );

            session()->flash('success','Registration Successful');

            return response()->json($response);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function authenticateUser(Request $request)
    {

        try {

            $rules = [
                'email'=>'required|email',
                'password'=> 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $user = User::where('email', $request->email)->first();

            if($user){

                if ($user->is_locked) {
                    $validator->getMessageBag()->add('email', 'Account Is Locked');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                if ($user->status == 'pending') {
                    $validator->getMessageBag()->add('email', 'Account Activation Pending by Admin');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }elseif ($user->status == 'denied') {
                    $validator->getMessageBag()->add('email', 'Account Access Denied by Admin');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                // $passwordExpiry = Carbon::parse($user->last_password_changed)->addDays(90);
                $passwordExpiry = Carbon::parse($user->last_password_changed ?? now()->subDays(91))->addDays(90);
                if($passwordExpiry < now()){
                    $validator->getMessageBag()->add('password', 'Password Expired - <a href="' . route('reset-password') . '">Reset Password</a>');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                if (Hash::check($request->password, $user->password)) {

                    $userData = [
                        'last_login' => now(),
                        'login_attempts' => 0
                    ];

                    User::where('email', $request->email)->update($userData);

                    $request->session()->put('username', $user->fname.' '.$user->lname);
                    $request->session()->put('userId', $user->id);
                    $request->session()->put('isUser', 'yes');
                    $request->session()->put('last_login', $user->last_login ?? now());

                    return response()->json([
                        'success' => true,
                        'message' => 'Login successful'
                    ]);

                }else{

                    $user->increment('login_attempts');

                    $validator->getMessageBag()->add('password', 5 - $user->login_attempts . ' - Attempts Left');

                    if ($user->login_attempts >= 5) {
                        $user->is_locked = true;
                        $validator->getMessageBag()->add('email', 'Account Is Locked Maximum Tries Reached');
                    }
                    $user->save();

                    throw new \Illuminate\Validation\ValidationException($validator);
                }
                
            }else{
                return response()->json([
                    'error' => true,
                    'error_type' => 'login',
                    'message' => 'User not found',
                    'errors' => ['email' => 'Email not registered']
                ], 422);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function resetPassword(Request $request)
    {

        try {

            $rules = [
                'email'=>'required|email',
                'otp'=>'required|numeric|digits:6',
                'password'=> 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password'=> 'required|same:password'
            ];

            $messages = [];

            $attributes = [
                'email'=>'Email',
                'otp'=>'OTP',
                'password'=> 'Password',
                'confirm_password'=> 'Confirm Password'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $user = User::where('email', $request->email)->first();

            if($user){

                if ($user->is_locked) {
                    $validator->getMessageBag()->add('email', 'Account Is Locked');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                if(session('otp') != $request->otp){
                    $validator->getMessageBag()->add('otp', 'OTP does not match');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }elseif (session('otp_email') !== $request->email) {
                    $validator->getMessageBag()->add('email', 'Email must match OTP sent email');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }elseif (session('otp_expires_at') < now()) {
                    $validator->getMessageBag()->add('otp', 'OTP Expired');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                $user->password = Hash::make($request->password);
                $user->last_password_changed = now();
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Password Change Successful'
                ]);
                
            }else{
                return response()->json([
                    'error' => true,
                    'error_type' => 'login',
                    'message' => 'User not found',
                    'errors' => ['email' => 'Email not registered']
                ], 422);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function my_account()
    {
        // $this->data['user'] = User::find(session('userId'));
        $this->data['dashboard'] = 'active';
        return view('electrical.my-account.dashboard', $this->data);
    }
    
    public function orders()
    {
        $this->data['orders'] = 'active';
        return view('electrical.my-account.orders', $this->data);
    }
    
    public function view_order($order_no)
    {
        $this->data['orders'] = 'active';
        $this->data['order'] = Order::where('order_ref_id',$order_no)->first();
        return view('electrical.my-account.view-order', $this->data);
    }
    
    public function addresses()
    {
        $this->data['addresses'] = 'active';
        return view('electrical.my-account.addresses', $this->data);
    }
    
    public function edit_address($id)
    {
        $this->data['addresses'] = 'active';
        return view('electrical.my-account.edit-address', $this->data);
    }
    
    public function address_update(Request $request)
    {

        try {

            $rules = [
                'billing_fname'=>'required|string|max:50',
                'billing_lname'=>'required|string|max:50',
                'billing_email'=>'required|email',
                'billing_phone'=>'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/',
                'billing_company'=>'nullable|string|max:255',
                'billing_address'=>'nullable|string|max:255',
                'billing_city'=>'nullable|string|max:100',
                'billing_state'=>'nullable|string|max:50',
                'billing_country'=>'nullable|string|max:60',
                'billing_postcode'=>'nullable|string|max:20',
                'same_address'=>'nullable',
                'shipping_fname'=>'required|string|max:50',
                'shipping_lname'=>'required|string|max:50',
                'shipping_email'=>'required|email',
                'shipping_phone'=>'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/',
                'shipping_company'=>'nullable|string|max:255',
                'shipping_address'=>'nullable|string|max:255',
                'shipping_city'=>'nullable|string|max:100',
                'shipping_state'=>'nullable|string|max:50',
                'shipping_country'=>'nullable|string|max:60',
                'shipping_postcode'=>'nullable|string|max:20',
            ];

            $validator = Validator::make($request->all(), $rules);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $validated['updated_by'] = session('username');

            if($request->same_address){
                $validated['same_address'] = 1;
            }else{
                $validated['same_address'] = 0;
            }
            // dd($validated['same_address']);

            User::find(session('userId'))->update($validated);

            // $user = User::find(session('userId'));

            // $user->save();

            session()->flash('success','Data Updation Successful');
            return response()->json([
                'success' => true,
                'message' => 'Data Updation Successful'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function account_details()
    {
        $this->data['accountDetails'] = 'active';
        return view('electrical.my-account.account-details', $this->data);
    }
    
    public function update_account_details(Request $request)
    {

        try {

            $rules = [
                'fname'=>'required|string|max:50',
                'lname'=>'required|string|max:50',
                'phone'=>'nullable|string|max:20',
                'current_password'=>'nullable',
                'new_password'=> 'nullable|required_with:current_password|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_new_password'=> 'bail|required_with:new_password|same:new_password'
            ];

            $messages = [];

            $attributes = [
                'fname'=>'First Name',
                'lname'=>'Last Name',
                'current_password'=>'Current Password',
                'new_password'=> 'New Password',
                'confirm_new_password'=> 'Confirm New Password'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $user = User::find(session('userId'));

            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->phone = $request->phone ?? NULL;

            if(!empty($request->new_password)){

                if (Hash::check($request->current_password, $user->password)){
                    if (Hash::check($request->new_password, $user->password)){
                        $validator->getMessageBag()->add('new_password', 'New and Current Password cannot be same');
                        throw new \Illuminate\Validation\ValidationException($validator);
                    }
                    $newPassword = Hash::make($request->new_password);
                    $user->password = $newPassword;
                    $user->last_password_changed = now();

                    session()->flash('password_changed','Password Change Successful');
                }else{
                    $validator->getMessageBag()->add('current_password', 'Incorrect Password');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

            }

            $user->save();
            session()->flash('success','Data Updation Successful');
            return response()->json([
                'success' => true,
                'message' => 'Data Updation Successful'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
    
    public function checkout()
    {
        $cartProducts = CartItem::with('product')->where('user_id',session('userId'))->get();

        // We only allow checkout page for minimum 1 product
        if(!empty($cartProducts) && count($cartProducts) > 0){
            return view('electrical.checkout');
        }else{
            return redirect()->route('cart.index');
        }
    }
    
    public function place_order(Request $request)
    {

        try {

            $rules = [
                'billing_fname'=>'required',
                'billing_lname'=>'required',
                'billing_email'=>'required|email',
                'billing_phone'=>'nullable|string|max:20',
                'billing_country'=>'required',
                'enquiry_notes'=>'nullable'
            ];

            $messages = [];

            $attributes = [
                'billing_fname'=>'First Name',
                'billing_lname'=>'Last Name',
                'company_name'=>'Company Name',
                'billing_email'=>'Email',
                'billing_phone'=>'Phone',
                'billing_country'=> 'Country'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $order_ref_id = date('Ymdhis');
            
            $orderData = array(
                'user_id'=>session('userId'),
                'order_ref_id'=>$order_ref_id,
                'billing_fname'=>$request->billing_fname,
                'billing_lname'=>$request->billing_lname,
                'billing_email'=>$request->billing_email,
                'billing_phone'=>$request->billing_phone,
                'billing_country'=>$request->billing_country,
                'enquiry_notes'=>$request->enquiry_notes,
                'created_by' => session('username'),
                'updated_by' => session('username')
            );

            // Create Order
            $order = Order::create($orderData);

            // Cart Products
            $cartProducts = CartItem::where('user_id',session('userId'))->get();

            // Create Order products
            $orderProductsData = [];
            foreach($cartProducts as $item){
                $orderProductsData[] =[
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Add Order Products Data
            $OrderProducts = OrderProduct::insert($orderProductsData);

            // Now delete cart as order placed
            CartItem::where('user_id', session('userId'))->delete();

            $user = User::find(session('userId'));

            $mailData = [
                'order_ref_id' => $order_ref_id,
                'created_at' => $order->created_at,
                'username' => $user->fname.' '.$user->lname,
                'email' => $user->email,
                'billing_email' => $request->billing_email ?? '',
                'enquiry_notes' => $request->enquiry_notes ?? '',
                'orderProducts' => $order->OrderProducts,
            ];

            Mail::to('info@oec-americas.com')->send(new ProductEnquiryMail($mailData));

            $response = array(
                'success' => true,
                'message' => 'Record created',
                'class' => 'alert alert-success'
            );

            return response()->json($response);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }
}
