<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Celebration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDonations = DB::table('donation')->count();
        $certificateDonationsCount = DB::table('certificate_donation')->count();
        $recentDonations = DB::table('donation')
            ->join('users', 'donation.phone_number', '=', 'users.phone_number')
            ->select('donation.*', 'users.name as user_name', 'users.email') // add any fields you want
            ->orderBy('donation.created_on', 'desc')
            ->take(5)
            ->get();
        
        $totalDonationCount = DB::table('donation')
            ->where('payment_status', 'complete')
            ->sum('amount') + 
            DB::table('certificate_donation')
            ->where('payment_status', 'complete')
            ->sum('amount');

        $pendingDonation = DB::table('donation')
            ->where('payment_status', 'pending')
            ->count() + 
            DB::table('certificate_donation')
            ->where('payment_status', 'pending')
            ->count();
        
        $completeDonation = DB::table('donation')
            ->where('payment_status', 'complete')
            ->count() + 
            DB::table('certificate_donation')
            ->where('payment_status', 'complete')
            ->count();

        // return $recentDonations;
        return view('admin.dashboard', compact('totalUsers', 'totalDonations', 'recentDonations', 'totalDonationCount', 'pendingDonation', 'certificateDonationsCount', 'completeDonation'));
    }

    public function users()
    {
        $users = DB::table('users')
            ->leftJoin('donation', function ($join) {
                $join->on('users.phone_number', '=', 'donation.phone_number')
                    ->where('donation.payment_status', '=', 'complete');
            })
            ->leftJoin('certificate_donation', function ($join) {
                $join->on('users.phone_number', '=', 'certificate_donation.number')
                    ->where('certificate_donation.payment_status', '=', 'complete');
            })
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone_number',
                'users.city',
                'users.state',
                DB::raw('COUNT(donation.id) as donations_count'),
                DB::raw('COALESCE(SUM(donation.amount), 0) + COALESCE(SUM(certificate_donation.amount), 0) as total_donations')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.phone_number', 'users.city', 'users.state')
            ->orderByDesc('users.id')
            ->get();



        $jsonPath = public_path('assets/indian-states-cities.json'); // Adjust path if needed

        if (!File::exists($jsonPath)) {
            abort(404, 'States and Cities data file not found.');
        }

        $statesCitiesArray = File::get($jsonPath);
        $statesCities = json_decode($statesCitiesArray);
        return view('admin.users.index', compact('users', 'statesCities'));
    }
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:15',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|max:10',
        ]);

        $user->update($validated);
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function donations(Request $request)
    {
        $donations = [];
        $donations['donation'] = DB::table('users')
            ->when($request->has('user'), function ($query) use ($request) {
                return $query->where('users.id', $request->input('user'));
            })
            ->leftJoin('donation', 'users.phone_number', '=', 'donation.phone_number')
            ->leftJoin('certificate_donation', 'users.phone_number', '=', 'certificate_donation.number')
            ->where(function ($query) {
                $query->where('donation.payment_status', '=', 'complete');
            })
            ->select('donation.*', 'users.*', 'donation.id as donation_id')
            ->distinct('donation.payment_id')
            ->orderByDesc('donation.created_on')
            ->get()->toArray();
        $donations['certificate_donation'] =  DB::table('users')
            ->when($request->has('user'), function ($query) use ($request) {
                return $query->where('users.id', $request->input('user'));
            })
            ->leftJoin('certificate_donation', 'users.phone_number', '=', 'certificate_donation.number')
            ->where(function ($query) {
                $query->where('certificate_donation.payment_status', '=', 'complete');
            })
            ->select('certificate_donation.*', 'users.*', 'certificate_donation.id as donation_id')
            ->orderByDesc('certificate_donation.created_on')
            ->get()->toArray();

        // $allDonations = array_merge($donations, $certDonaions);

        // return $donations;
        return view('admin.donations.index', compact('donations'));
    }

    public function celebrations()
    {
        $celebrations = Celebration::with('user')->latest()->get();
        return view('admin.celebrations.index', compact('celebrations'));
    }

    public function deleteCelebration(Celebration $celebration)
    {
        $celebration->delete();
        return redirect()->route('admin.celebrations')->with('success', 'Celebration deleted successfully');
    }

    public function addUser(Request $request)
    {
        // dd($request->all());
        // Step 1: Validate input (excluding unique checks)
        $validator = Validator::make($request->all(), [
            'salutation' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|max:10',
            'user_type' => 'required|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->user_type == 'admin') {
            $existingAdmin = DB::table('admins')->where('email', $request->email)
                ->orWhere('phone_number', $request->phone_number)
                ->first();

            if ($existingAdmin) {
                $message = '';

                if ($existingAdmin->email === $request->email && $existingAdmin->phone_number === $request->phone_number) {
                    $message = 'A user with this email and phone number already exists.';
                } elseif ($existingAdmin->email === $request->email) {
                    $message = 'A user with this email already exists.';
                } else {
                    $message = 'A user with this phone number already exists.';
                }

                return response()->json(['message' => $message], 409);
            }

            $userData = [
                'salutation' => $request->salutation,
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dob' => $request->dob,
                'country' => 'India',
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'address' => $request->address,
                // 'reference_id' => auth()->user()->id,
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            DB::table('admins')->insert($userData);

            return response()->json(['message' => 'User created successfully'], 200);
        }
        // Step 2: Check if user already exists by email or phone
        $existingUser = User::where('email', $request->email)
            ->orWhere('phone_number', $request->phone_number)
            ->first();

        if ($existingUser) {
            $message = '';

            if ($existingUser->email === $request->email && $existingUser->phone_number === $request->phone_number) {
                $message = 'A user with this email and phone number already exists.';
            } elseif ($existingUser->email === $request->email) {
                $message = 'A user with this email already exists.';
            } else {
                $message = 'A user with this phone number already exists.';
            }

            return response()->json(['message' => $message], 409);
        }

        // Step 3: Proceed with user creation
        try {
            $user = new User();
            $user->salutation = $request->salutation;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->dob = $request->dob;
            $user->country = 'India';
            $user->state = $request->state;
            $user->city = $request->city;
            $user->pincode = $request->pincode;
            // $user->source = $request->source;
            $user->address = $request->address;
            $user->reference_id = auth()->user()->id;
            $user->password = Hash::make('password');
            $user->save();

            return response()->json(['message' => 'User created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering reference: ' . $e->getMessage()], 500);
        }
    }
    
    public function sendPassword(User $user)
    {
        // Generate a new random password
        $password = $this->generateRandomPassword(); // Use $this-> only if it's a method in the same class
    
        // Hash the password
        $user->password = bcrypt($password); // bcrypt is Laravel's helper
        $user->save(); // Don't forget to save the updated password
    
        // Send the password via SMS
        $phone = $user->phone_number;
        $username = $user->username;
        $url = "https://gausevasociety.com/donation-portal/login";
        $message = "Welcome to Shree Ji Gau Sewa Society. Username: $username Password: $password Keep it safe. Login at our donor website.";
    
        // Call your existing SMS function (assumed to be defined in same class or accessible globally)
        $this->sendOtpSms($phone, $message);
    
        return response()->json(['message' => 'Password sent successfully to the user.']);
    }
        
    public function sendOtpSms(string $phoneNumber, string $message) {
        $api_url = "https://sms.smswala.in/app/smsapi/index.php";
        $api_key = '4682834A3A5BDC';
        $campaign_id = rawurlencode(' 16567'); // Note the leading space
        $route_id = '30';
        $sender_id = rawurlencode(' GAUSEW'); // Note the leading space
        $template_id = '1707174781800728856';
        
        // $message = "Welcome to Shree Ji Gau Sewa Society. Username: 0000 Password: 1111 Keep it safe. Login at our donor website. 2222";
        $encodedMessage = rawurlencode($message);
    
    
        $url = "$api_url?key=$api_key&campaign=$campaign_id&routeid=$route_id&type=text&contacts=$phoneNumber&senderid=$sender_id&msg=$encodedMessage&template_id=$template_id";
    
        $response = file_get_contents($url);
    
        // Optionally log or handle response
        if ($response === false) {
            error_log("Failed to send SMS to $phoneNumber.");
        } else {
            error_log("SMS sent to $phoneNumber: $response");
        }
    }
    
    public function generateRandomPassword() {
        return str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
    }

    public function settings(){
        return view('admin.settings');
    }
}
