<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $donatedAmount = DB::table('donation')->where('phone_number', $user->phone_number)->where('payment_status', 'complete')->sum('amount');
        $eightyGAmount = DB::table('certificate_donation')->where('number', $user->phone_number)->where('payment_status', 'complete')->sum('amount');
        $donations = DB::table('donation')->where('phone_number', $user->phone_number)->where('payment_status', '!=', 'complete')->orderByDesc('id')->get();
        // $eightyGDonations = DB::table('certificate_donation')->where('number', $user->phone_number)->where('payment_status', 'complete')->orderByDesc('id')->get();

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $donatedAmountMonthly = DB::table('donation')
            ->where('phone_number', $user->phone_number)
            ->where('payment_status', 'complete')
            ->whereMonth('created_on', $currentMonth)
            ->whereYear('created_on', $currentYear)
            ->sum('amount');

        $eightyGAmountMonthly = DB::table('certificate_donation')
            ->where('number', $user->phone_number)
            ->where('payment_status', 'complete')
            ->whereMonth('created_on', $currentMonth)
            ->whereYear('created_on', $currentYear)
            ->sum('amount');

        $monthly = $donatedAmountMonthly + $eightyGAmountMonthly;

        return view('donars.dashboard.index', compact('donatedAmount', 'donations', 'eightyGAmount', 'monthly'));
    }

    public function settings()
    {
        $jsonPath = public_path('assets/indian-states-cities.json'); // Adjust path if needed

        if (!File::exists($jsonPath)) {
            abort(404, 'States and Cities data file not found.');
        }
    
        $statesCities = File::get($jsonPath);
        
        
        return view('donars.dashboard.settings', compact('statesCities'));
    }

    public function profileSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone_number' => 'required|string|max:15',
            'pan_number' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'user_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = Auth::user();
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'pan_number' => $request->pan_number,
                'country' => $request->country,
                'pincode' => $request->pincode,
                'city' => $request->city,
                'state' => $request->state,
                'address' => $request->address,
                'salutation' => $request->salutation,
                'gender' => $request->gender,
                'father_spouse_name' => $request->father_spouse_name,
            ];

            if ($request->hasFile('user_img')) {
                // Delete old image if exists
                if ($user->user_img && file_exists(public_path($user->user_img))) {
                    unlink(public_path($user->user_img));
                }

               $image = $request->file('user_img');
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $image->move(public_path('uploads/users'), $filename);
                $updateData['user_img'] = $filename;
            }

            User::where('id', $user->id)->update($updateData);

            $jsonPath = public_path('assets/indian-states-cities.json');
            if (!File::exists($jsonPath)) {
                abort(404, 'States and Cities data file not found.');
            }
            $statesCities = File::get($jsonPath);

            // return view('donars.dashboard.settings', compact('statesCities'));
            return redirect()->route('settings');

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating profile: ' . $e->getMessage()], 500);
        }
    }
}
