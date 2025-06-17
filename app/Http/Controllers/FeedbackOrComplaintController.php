<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FeedbackOrComplaintController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('donars.dashboard.feedback', compact('feedbacks'));
    }
    /**
     * Store a newly created feedback in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feedback_type' => 'required|integer|min:1|max:5',
            'description' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feedback_detail' => 'nullable|integer',
            'other_details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $feedbackData = $request->except('attachment');

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $filename);
            $feedbackData['attachment'] = 'uploads/' . $filename;
        }

        // Set user and default status
        $feedbackData['user_id'] = auth()->user()->id;
        $feedbackData['status'] = 0;

        // Generate ticket ID
        $latestFeedback = Feedback::latest('id')->first();
        $nextId = $latestFeedback ? $latestFeedback->id + 1 : 1;
        $feedbackData['feedback_id'] = 'GT' . str_pad($nextId, 10, '0', STR_PAD_LEFT);

        // Store feedback
        Feedback::create($feedbackData);

        // Return view
        $feedbacks = Feedback::where('user_id', auth()->user()->id)->latest()->get();
        return view('donars.dashboard.feedback', compact('feedbacks'));
    }

    /**
     * Display the specified feedback.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Feedback $feedback)
    {
        return response()->json(['feedback' => $feedback]);
    }

    /**
     * Update the specified feedback in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Feedback $feedback)
    {
        $validator = Validator::make($request->all(), [
            'feedback_type' => 'required|integer|min:1|max:5',
            'description' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feedback_detail' => 'nullable|integer',
            'other_details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $feedbackData = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            // Delete the old image if it exists
            if ($feedback->attachment && file_exists(public_path($feedback->attachment))) {
                unlink(public_path($feedback->attachment));
            }
            $image = $request->file('attachment');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $filename);
            $feedbackData['attachment'] = 'uploads/' . $filename;
        }

        $feedback->update($feedbackData);

        return response()->json(['message' => 'Feedback updated successfully', 'feedback' => $feedback]);
    }

    /**
     * Remove the specified feedback from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Feedback $feedback)
    {
        // Delete the associated image if it exists
        if ($feedback->attachment && file_exists(public_path($feedback->attachment))) {
            unlink(public_path($feedback->attachment));
        }

        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully']);
    }
}
