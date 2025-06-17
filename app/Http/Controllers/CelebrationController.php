<?php

namespace App\Http\Controllers;

use App\Models\Celebration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CelebrationController extends Controller
{
    public function index()
    {
        $celebrations = Celebration::where('user_id', auth()->id())->get();
        return view('donars.dashboard.celebrations.index', compact('celebrations'));
    }

    public function create()
    {
        return view('donars.dashboard.celebrations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'relation' => 'required|string|max:255',
            'type' => 'required|in:Anniversary,Birthday',
            'schedule_date' => 'required|date',
            'gotra' => 'required|string|max:255',
            'remarks' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->except('image');
            $data['user_id'] = auth()->id();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $image->move(public_path('uploads/celebrations'), $filename);
                $data['image'] = $filename;
            }

            Celebration::create($data);
            return response()->json(['message' => 'Celebration created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating celebration: ' . $e->getMessage()], 500);
        }
    }

    public function edit(Celebration $celebration)
    {
        if ($celebration->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($celebration);
    }

    public function update(Request $request, Celebration $celebration)
    {
        if ($celebration->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'relation' => 'required|string|max:255',
            'type' => 'required|in:Anniversary,Birthday',
            'schedule_date' => 'required|date',
            'gotra' => 'required|string|max:255',
            'remarks' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($celebration->image && file_exists(public_path('uploads/celebrations/' . $celebration->image))) {
                    unlink(public_path('uploads/celebrations/' . $celebration->image));
                }

                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $image->move(public_path('uploads/celebrations'), $filename);
                $data['image'] = $filename;
            }

            $celebration->update($data);
            return response()->json(['message' => 'Celebration updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating celebration: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Celebration $celebration)
    {
        if ($celebration->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            // Delete image if exists
            if ($celebration->image && file_exists(public_path('uploads/celebrations/' . $celebration->image))) {
                unlink(public_path('uploads/celebrations/' . $celebration->image));
            }

            $celebration->delete();
            return response()->json(['message' => 'Celebration deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting celebration: ' . $e->getMessage()], 500);
        }
    }
} 