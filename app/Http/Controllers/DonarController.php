<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\Storage;
class DonarController extends Controller
{
    public function donations(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status');

        // Initialize queries
        $donationQuery = DB::table('donation')->where('phone_number', $user->phone_number);
        $eightyGQuery = DB::table('certificate_donation')->where('number', $user->phone_number);

        // Apply filter only if status is passed
        if (!empty($status) &&  $status != 'null') {
            $donatedAmount = (clone $donationQuery)->where('payment_status', $status)->sum('amount');
            $eightyGAmount = (clone $eightyGQuery)->where('payment_status', $status)->sum('amount');

            $donations = (clone $donationQuery)->where('payment_status', $status)->orderByDesc('id')->get();
            $eightyGDonations = (clone $eightyGQuery)->where('payment_status', $status)->orderByDesc('id')->get();
        } else {
            $donatedAmount = $donationQuery->sum('amount');
            $eightyGAmount = $eightyGQuery->sum('amount');

            $donations = $donationQuery->orderByDesc('id')->get();
            $eightyGDonations = $eightyGQuery->orderByDesc('id')->get();
        }

        return view('donars.dashboard.donations', compact('donatedAmount', 'eightyGAmount', 'donations', 'eightyGDonations'));
    }
    
    public function eightyGDonations(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status');

        // Initialize queries
        $donationQuery = DB::table('donation')->where('phone_number', $user->phone_number);
        $eightyGQuery = DB::table('certificate_donation')->where('number', $user->phone_number);

        // Apply filter only if status is passed
        if (!empty($status) &&  $status != 'null') {
            $donatedAmount = (clone $donationQuery)->where('payment_status', $status)->sum('amount');
            $eightyGAmount = (clone $eightyGQuery)->where('payment_status', $status)->sum('amount');

            $donations = (clone $donationQuery)->where('payment_status', $status)->orderByDesc('id')->get();
            $eightyGDonations = (clone $eightyGQuery)->where('payment_status', $status)->orderByDesc('id')->get();
        } else {
            $donatedAmount = $donationQuery->sum('amount');
            $eightyGAmount = $eightyGQuery->sum('amount');

            $donations = $donationQuery->orderByDesc('id')->get();
            $eightyGDonations = $eightyGQuery->orderByDesc('id')->get();
        }
        
        // return $eightyGDonations;

        return view('donars.dashboard.donations', compact('donatedAmount', 'eightyGAmount', 'donations', 'eightyGDonations'));
    }

    public function getMonthlyDdonations(Request $request)
    {
        return view('donar.index');
    }
    public function getConsolidatedReceipt(Request $request)
    {
        return view('donar.index');
    }

    public function onlineDonation(Request $request) {
        $user = auth()->user();
        return view('donars.dashboard.online-donation', compact('user'));
    }
    
    public function getMyReferences(){
        $user = auth()->user();
        $references = User::where('reference_id', $user->id)->get();
        return view('donars.dashboard.references', compact('user', 'references'));
    }
    
    public function getRefferenceRegistration(){
        $jsonPath = public_path('assets/indian-states-cities.json'); // Adjust path if needed

        if (!File::exists($jsonPath)) {
            abort(404, 'States and Cities data file not found.');
        }
    
        $statesCitiesArray = File::get($jsonPath);
        $statesCities = json_decode($statesCitiesArray);
        
        // return $statesCities;
        return view('donars.dashboard.create-references', compact('statesCities'));
    }

    public function saveRefferenceRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salutation' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            // 'country' => 'required|string',
            'state' => 'required|string',
            // 'district' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|max:10',
            'source' => 'required|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Create new user
            $user = new User();
            $user->salutation = $request->salutation;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->dob = $request->dob;
            $user->country = 'India';
            $user->state = $request->state;
            // $user->district = $request->district;
            $user->city = $request->city;
            $user->pincode = $request->pincode;
            $user->source = $request->source;
            $user->address = $request->address;
            $user->reference_id = auth()->user()->id;
            $user->password = Hash::make(Str::random(10)); // Generate random password
            $user->save();

            return response()->json(['message' => 'Reference registered successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering reference: ' . $e->getMessage()], 500);
        }
    }
    
    public function deleteRefferenceRegistration(Request $request){
        $id = $request->id;
        User::where('id', $id)->delete();
        return response()->json(['message' => 'Reference deleted successfully'], 200);
    }
    
    public function consolidatedReceipts()
    {
        return view('donars.dashboard.consolidated-receipts');
    }
    
    
     public function generateConsolidatedReceipt(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $phone_number = auth()->user()->phone_number;
        // Get donations for the date range
        $donationSum = DB::table('donation')
            ->where('phone_number', $phone_number)
            ->where('payment_status', 'complete')
            ->whereBetween('created_on', [$request->start_date, $request->end_date])
            ->sum('amount');
        
        $certificateDonationSum = DB::table('certificate_donation')
            ->where('number', $phone_number)
            ->where('payment_status', 'complete')
            ->whereBetween('created_on', [$request->start_date, $request->end_date])
            ->sum('amount');
        
        $totalAmount = $donationSum + $certificateDonationSum;


        if ($totalAmount <= 0) {
            return response()->json(['error' => 'No donations found for the selected date range'], 404);
        }

        // Calculate total amount
        // $totalAmount = $donations->sum('amount');

        // Generate receipt number
        $receiptNo = 'CR-' . date('Ymd') . '-' . str_pad(rand(10,100), 6, '0', STR_PAD_LEFT);

        // Prepare data for PDF
        $data = [
            'totalAmount' => $totalAmount,
            'receiptNo' => $receiptNo,
            'user' => auth()->user(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
            
        ];

        // Generate PDF
        $pdf = PDF::loadView('donars.dashboard.consolidated-receipt-pdf', $data);

        // Create directory if it doesn't exist
        $directory = public_path('receipts');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate unique filename
        $filename = 'consolidated-receipt-' . $request->start_date . '-to-' . $request->end_date . '-' . uniqid() . '.pdf';
        $filepath = $directory . '/' . $filename;

        // Save PDF directly to public directory
        $pdf->save($filepath);

        // Return PDF URL
        return response()->json([
            'pdf_url' => asset('public/receipts/' . $filename)
        ]);
    
    }
}
