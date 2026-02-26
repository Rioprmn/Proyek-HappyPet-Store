<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo && File::exists(public_path('assets/img/profiles/' . $user->photo))) {
                File::delete(public_path('assets/img/profiles/' . $user->photo));
            }
            $photoName = time() . '_' . Str::slug($user->name) . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/img/profiles'), $photoName);
            $data['photo'] = $photoName;
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile berhasil diupdate!');
    }
}
