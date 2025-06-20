<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mulai query builder
        $query = User::with('roles')->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'super_admin');
        });

        // Tambahkan pencarian jika ada input
        if (!empty($search)) {
            $keywords = explode(' ', $search);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($subQuery) use ($word) {
                        $subQuery->where('name', 'like', "%$word%")
                            ->orWhere('email', 'like', "%$word%")
                            ->orWhere('phone', 'like', "%$word%");
                    });
                }
            });
        }

        $users = $query->orderBy('name')->get();

        return view('admin.pengguna.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('admin.pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'roles' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'phone', 'gender');

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->assignRole($request->roles);

        return redirect()->route('admin.pengguna.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.pengguna.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|unique:users,phone,' . $id,
            'password' => 'nullable',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'roles' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $data = $request->only('name', 'email', 'phone', 'gender');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->roles]);

        return redirect()->route('admin.pengguna.index')->with('success', 'User berhasil diupdate.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'User berhasil di hapus.');
    }

    public function show($id)
    {
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Kirim data pengguna ke view
        return view('admin.pengguna.show', compact('user'));
    }
}
