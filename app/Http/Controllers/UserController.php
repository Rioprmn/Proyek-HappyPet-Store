<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Sort
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        if ($sort == 'name') {
            $query->orderBy('name', $direction);
        } elseif ($sort == 'email') {
            $query->orderBy('email', $direction);
        } elseif ($sort == 'role') {
            $query->orderBy('role', $direction);
        } elseif ($sort == 'date') {
            $query->orderBy('created_at', $direction);
        }

        $users = $query->get();
        
        return view('admin.user-list', compact('users', 'sort', 'direction'));
    }

    public function create()
    {
        return view('admin.user-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/img/profiles'), $photoName);
            $data['photo'] = $photoName;
        }

        User::create($data);

        return redirect()->route('admin.user.list')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && File::exists(public_path('assets/img/profiles/' . $user->photo))) {
                File::delete(public_path('assets/img/profiles/' . $user->photo));
            }
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/img/profiles'), $photoName);
            $data['photo'] = $photoName;
        }

        $user->update($data);

        return redirect()->route('admin.user.list')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->photo && File::exists(public_path('assets/img/profiles/' . $user->photo))) {
            File::delete(public_path('assets/img/profiles/' . $user->photo));
        }
        
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
