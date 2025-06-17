<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Receipt; // Assuming your model is named Receipt
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use DB;


class ReceiptsController extends Controller
{
    /**
     * Display a listing of the receipts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = DB::table('receipts')->get(); // Or paginate, etc.
        return view('admin.receipts.index', compact('receipts')); // Make sure this path is correct
    }

    /**
     * Store a newly created receipt in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/', // 10-digit number
            // 'pan' => 'string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            // 'adhar_card' => 'optional',
            'address' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in(['online', 'cash', 'upi'])],
        ],
        [
            'phone_number.regex' => 'The phone number must be a 10-digit number.',
            'pan.regex' => 'The PAN number format is invalid.',
            'adhar_card.regex' => 'The Adhar Card number format is invalid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        
        $userCheck = DB::table('users')->where('phone_number', $request->phone_number)->first();
        $user_id = null;
        if($userCheck){
            $user_id = $userCheck->id;
        }else{
           $user_id = DB::table('users')->insertGetId([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'pan_number' => $request->input('pan') ?? null,
                'password' => Hash::make($request->input('phone_number')),
                'address' => $request->input('address'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        
        $receipt = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'pan' => $request->input('pan') ?? null,
            'adhar_card' => $request->input('adhar_card') ?? null,
            'address' => $request->input('address'),
            'amount' => $request->input('amount'),
            'payment_method' => $request->input('payment_method'),
            'user_id' => $user_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        
        DB::table('receipts')->insert($receipt);

        return response()->json([
            'success' => true,
            'message' => 'Receipt added successfully!',
            'data' => $receipt,
        ], 200);
    }

    /**
     * Display the specified receipt.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = Receipt::findOrFail($id);
        return view('admin.receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receipt = Receipt::findOrFail($id);
        return view('admin.receipts.edit', compact('receipt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/', // 10-digit number
             'pan' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'adhar_card' => 'required|string|regex:/^[2-9]{1}[0-9]{3}\s[0-9]{4}\s[0-9]{4}$/',
            'address' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in(['online', 'cash', 'upi'])],
        ],
        [
            'phone_number.regex' => 'The phone number must be a 10-digit number.',
            'pan.regex' => 'The PAN number format is invalid.',
            'adhar_card.regex' => 'The Adhar Card number format is invalid.',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $receipt->name = $request->input('name');
        $receipt->email = $request->input('email');
        $receipt->phone_number = $request->input('phone_number');
         $receipt->pan = $request->input('pan');
        $receipt->adhar_card = $request->input('adhar_card');
        $receipt->address = $request->input('address');
        $receipt->amount = $request->input('amount');
        $receipt->payment_method = $request->input('payment_method');
        $receipt->updated_at = Carbon::now();
        $receipt->save();

        return response()->json([
            'success' => true,
            'message' => 'Receipt updated successfully!',
            'data' => $receipt,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receipt = DB::table('receipts')->where('id',$id)->delete();

         return redirect()->route('admin.reciepts');
    }
}
