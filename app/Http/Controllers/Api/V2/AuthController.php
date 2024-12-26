<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Http\Requests\Api\SignupRequest;
use App\Models\BusinessSetting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\AppEmailVerificationNotification;
use Hash;
use DB;


class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => preg_replace('/[^0-9]/', '', $request->phone),
            'password' => Hash::make($request->password),
            'user_type' => 'customer',
        ]);

        $otpController = new OTPVerificationController();
        $otpController->send_code($user);

        Customer::create([
            'user_id' => $user->id
        ]);

        

        $details = [
            'name' => $request->name,
            'subject' => 'Registration Successful - Welcome to '.env('APP_NAME').'!',
            'body' => " <p> Congratulations and welcome to ".env('APP_NAME')."! We are delighted to inform you that your registration has been successfully completed. Thank you for choosing us as your trusted pharmacy partner.</p><br>

            <p>We are committed to providing you with exceptional service and ensuring that your online shopping experience is smooth and hassle-free. If you have any questions or need assistance, our customer support team is here to help.</p><br>
            <p>Thank you for choosing ".env('APP_NAME').". We look forward to serving you and meeting all your pharmaceutical needs.</p>"
        ];
       
         \Mail::to($request->email)->send(new \App\Mail\SendMail($details));

        $result = [
            'status' => true,
            'message' => 'Registration Successful. OTP has been sent to your phone, please verify and log in to your account.',
            'user_id' => $user->id
        ];

        if (env('APP_DEBUG') == true) {
            $result['otp'] = $user->verification_code;
        }

        return response()->json($result, 200);
    }

    public function resend_otp(Request $request)
    {
        if ($request->user_id) {
            $user = User::findOrFail($request->user_id);
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);

            $result = [
                'status' => true,
                'message' => 'OTP resend',
            ];

            if (env('APP_DEBUG') == true) {
                $result['otp'] = $user->verification_code;
            }

            return response()->json($result, 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid data, please provide a user id',
        ], 200);
    }

    public function verify_otp(Request $request)
    {
        if ($request->user_id && $request->otp) {
            $user = User::findOrFail($request->user_id);

            if (Carbon::now()->gt($user->verification_code_expiry)) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP exprired, please try again',
                ], 200);
            } else if ($user->verification_code !== $request->otp) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP, please try again',
                ], 200);
            }

            if ($user->phone_verified == 0) {
                $user->phone_verified = 1;
            }

            $user->verification_code_expiry = null;
            $user->verification_code = null;

            $user->save();

            return $this->loginSuccess($user);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid data, please provide a user id and otp',
        ], 200);
    }



    public function resendCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->verification_code = rand(100000, 999999);

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => translate('Verification code is sent again'),
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->save();
            return response()->json([
                'result' => true,
                'message' => translate('Your account is now verified.Please login'),
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => translate('Code does not match, you can request for resending the code'),
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $device_token = $request->has('device_token') ? $request->device_token : NULL ;
        $delivery_boy_condition = $request->has('user_type') && $request->user_type == 'delivery_boy';

        if ($delivery_boy_condition) {
            $user = User::whereIn('user_type', ['delivery_boy'])->where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first();
        } else {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first();
        }

        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                $user->device_token = $device_token;
                $user->save();
                return $this->loginSuccess($user);
            } else {
                return response()->json(['result' => false, 'message' => 'Incorrect Password', 'user' => null], 200);
            }
        } else {
            return response()->json(['result' => false, 'message' => translate('User not found'), 'user' => null], 200);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => translate('Successfully logged out')
        ]);
    }

    protected function loginSuccess($user)
    {
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged in'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => null,
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => api_asset($user->avatar_original),
                'phone' => $user->phone,
                "eid_front" => $user->getEidFrontImage(),
                "eid_back" => $user->getEidBackImage(),
                "is_verified" => ($user->phone_verified == 1) ? true : false
            ]
        ], 200);
    }


    public function signup2(Request $request)
    {
        if (User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first() != null) {
            return response()->json([
                'result' => false,
                'message' => translate('User already exists.'),
                'user_id' => 0
            ], 400);
        }

        if ($request->register_by == 'email') {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email_or_phone,
                'password' => Hash::make($request->password),
                'verification_code' => rand(100000, 999999)
            ]);
        } else {
            $user = new User([
                'name' => $request->name,
                'phone' => $request->email_or_phone,
                'password' => Hash::make($request->password),
                'verification_code' => rand(100000, 999999)
            ]);
        }

        if ($request->register_by == 'email') {
            if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                $user->email_verified_at = date('Y-m-d H:m:s');
            } else {
                try {
                    $user->notify(new AppEmailVerificationNotification());
                } catch (\Exception $e) {
                }
            }
        } else {
        }

        $user->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();

        //create token
        $user->createToken('tokens')->plainTextToken;

        return response()->json([
            'result' => true,
            'message' => translate('Registration Successful. Please verify and log in to your account.'),
            'user_id' => $user->id
        ], 200);
    }

    public function check_user_exist(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required'
        ]);

        $user = User::whereEmail($request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first();

        if ($user) {
            if ($this->isEmail($request->email_or_phone)) {
                return response()->json([
                    'status' => true,
                    'is_password' => true,
                    'is_otp' => false,
                    'user_id' => $user->id,
                    'user_exist' => true,
                    'message' => "User exists"
                ]);
            } else {
                $otpController = new OTPVerificationController();
                $otpController->send_code($user);

                $result = [
                    'status' => true,
                    'is_password' => false,
                    'is_otp' =>  true,
                    'user_id' => $user->id,
                    'user_exist' => true,
                ];

                if (env('APP_DEBUG') == true) {
                    $result['otp'] = $user->verification_code;
                }

                return response()->json($result, 200);
            }
        } else {
            return response()->json([
                'status' => true,
                'user_exist' => false,
                'message' => 'The user does not exist.'
            ], 200);
        }
    }

    public function isEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
