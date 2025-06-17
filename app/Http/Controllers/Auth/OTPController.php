<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Twilio\Rest\Client;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $phone = $request->phone;

        // Check if user exists in DB, if not create a new user
        $user = User::firstOrCreate(['phone' => $phone]);

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Send OTP via Twilio (or another service)
        $this->sendOtpViaTwilio($phone, $otp);

        // Save OTP to database (with expiration time)
        $user->otp = $otp;
        $user->otp_sent_at = now();
        $user->save();

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    // Send OTP via Twilio (or any SMS service you prefer)
    private function sendOtpViaTwilio($phone, $otp)
    {
        // $sid = env('TWILIO_SID');
        // $token = env('TWILIO_AUTH_TOKEN');
        // $twilio = new Client($sid, $token);

        // $message = "Your OTP code is: $otp";

        // $twilio->messages->create(
        //     $phone, 
        //     [
        //         'from' => env('TWILIO_PHONE_NUMBER'),
        //         'body' => $message
        //     ]
        // );
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;

        // Retrieve user by phone
        $user = User::where('phone', $phone)->first();

        if (!$user || $user->otp !== $otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // OTP is valid, proceed to login logic
        $user->otp = null;  // Clear OTP after successful validation
        $user->otp_sent_at = null;  // Clear OTP sent time
        $user->save();

        // Log the user in (e.g., via session, JWT, etc.)
        auth()->login($user);

        return response()->json(['message' => 'Login successful']);
    }
}
