<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Validator;
use Mail;
use Carbon\Carbon;
use App\Mail\PasswordResetOtpMail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function sendOtpViaEmail(Request $request)
    {
        try {

            $validated = $request->validate([
                'email' => 'required|email|unique:users,email'
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
                'email'=>'required|email|unique:users,email',
                'otp'=>'required|numeric|digits:6',
                'password'=> 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password'=> 'required|same:password',
                'accept_terms'=>'required'
            ];

            $messages = [];

            $attributes = [
                'fname'=>'First Name',
                'lname'=>'Last Name',
                'company_name'=>'Company Name',
                'email'=>'Email',
                'otp'=>'OTP',
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
                'company_name' => $request->company_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'last_password_changed' => now(),
                'registered_at' => now(),
                'created_by' => $request->fname.' '.$request->lname,
                'updated_by' => $request->fname.' '.$request->lname
            );

            User::create($data);

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

                $passwordExpiry = Carbon::parse($user->last_password_changed)->addDays(90);
                if($passwordExpiry < now()){
                    $validator->getMessageBag()->add('password', 'Password Expired');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                if (Hash::check($request->password, $user->password)) {

                    $userData = [
                        'last_login' => now(),
                        'login_attempts' => 0
                    ];

                    User::where('email', $request->email)->update($userData);

                    $request->session()->put('username', $user->fname.' '.$user->lname);
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

    public function logout()
    {
        session()->flush();
    }
}
