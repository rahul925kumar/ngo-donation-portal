<?php

namespace App\Http\Controllers;

use App\Models\PhoneOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Assuming you have a login.blade.php
    }

    public function checkUserAndSendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $phoneNumber = $request->input('phone_number');
        $user = User::where('phone_number', $phoneNumber)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Phone number not registered.'], 404);
        }

        $otp = mt_rand(100000, 999999);
        $this->sendOtpSms($phoneNumber, $otp);
        $expiry = now()->addMinutes(5);

        // Store OTP in the database
        PhoneOtp::updateOrCreate(
            ['phone_number' => $phoneNumber],
            ['otp' => $otp, 'expires_at' => $expiry]
        );

        // In a real application, send the OTP via SMS
        Log::info("Generated OTP for {$phoneNumber}: {$otp}"); // Log for testing

        return response()->json(['success' => true, 'message' => 'OTP sent successfully!']);
    }

    public function verifyOtpAndLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
            'otp' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $phoneNumber = $request->input('phone_number');
        $enteredOtp = $request->input('otp');

        $phoneOtp = PhoneOtp::where('phone_number', $phoneNumber)
            ->where('otp', $enteredOtp)
            ->where('expires_at', '>', now())
            ->first();

        if ($phoneOtp) {
            // OTP is valid, delete it from the database
            $phoneOtp->delete();

            $user = User::where('phone_number', $phoneNumber)->first();

            if ($user) {
                Auth::login($user);
                return response()->json(['success' => true]);
            } else {
                // This should ideally not happen if checkUserAndSendOtp worked correctly
                return response()->json(['success' => false, 'message' => 'User not found.'], 404);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Authentication successful
            $request->session()->regenerate();

            return response()->json(['success' => true, 'redirect_url' => '/dashboard']); // Adjust the redirect URL as needed
        } else {
            // Authentication failed
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }
    }
    
    private function sendOtpSms(string $phoneNumber, int $otp)
    {
      $api_url = "https://sms.smswala.in/app/smsapi/index.php";
      $api_key = env('SMSWALA_API_KEY', '4682834A3A5BDC'); // Store API key in .env
      $campaign_id = env('SMSWALA_CAMPAIGN_ID', '16567'); // Store campaign ID in .env
      $route_id = env('SMSWALA_ROUTE_ID', '30'); // Store route ID in .env
      $sender_id = env('SMSWALA_SENDER_ID', 'GAUSEW'); // Store sender ID in .env
      $template_id = env('SMSWALA_TEMPLATE_ID', '1707174747395564503'); // Store template ID in .env
      $message = urlencode("Your OTP for login is: $otp and is valid for 5 mins. Please don't share this OTP to keep your account safe. - Shree Ji Gau Sewa Society"); // URL encode the message
    
      try {
       $response = Http::get($api_url, [
        'key' => $api_key,
        'campaign' => $campaign_id,
        'routeid' => $route_id,
        'type' => 'text',
        'contacts' => $phoneNumber, // Send to the specific user's phone number
        'senderid' => $sender_id,
        'msg' => $message,
        'template_id' => $template_id,
       ]);
    
       // Log the API response for debugging
       // Log::info("SMS API Response for {$phoneNumber}:", $response->json());
    
       // You might want to check the response status or body for success/failure
       if ($response->successful()) {
        // SMS sent successfully
        Log::info("OTP sent successfully to {$phoneNumber}");
       } else {
        Log::error("Failed to send OTP to {$phoneNumber}. Status: {$response->status()}, Body: {$response->body()}");
        // Consider logging or handling the failure (e.g., retry mechanism)
       }
    
      } catch (\Exception $e) {
       Log::error("Error sending SMS to {$phoneNumber}: {$e->getMessage()}");
       // Handle the exception (e.g., network error)
      }
     }
     
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password updated successfully.');
    }
}