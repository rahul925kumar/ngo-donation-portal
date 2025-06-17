<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function show()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();
        
        $user->name = $request->name;
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.settings.show')
            ->with('success', 'Profile updated successfully');
    }
} 