<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('role_name', '!=', 'customer');
        })->orderBy('fullname')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('role_name', '!=', 'customer')->get();
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'username' => 'required|string|max:255|unique:users',
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'username.required' => 'Username is required.',
                'username.unique' => 'Username is already in use.',
                'fullname.required' => 'Full name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email format is not valid.',
                'email.unique' => 'Email is already in use.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'phone.required' => 'Phone number is required.',
                'role_id.required' => 'Role is required.',
                'role_id.exists' => 'The selected role is invalid.',
            ]
        );
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);
        return redirect()->route('users.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate(
            [
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8', function ($attribute, $value, $fail) {
                    if (Hash::check($value, User::findOrFail($id)->password)) {
                        $fail('The new password cannot be the same as the current password.');
                    }
                },
                'phone' => 'required|string|max:20',
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'username.required' => 'Username is required.',
                'username.unique' => 'Username is already in use.',
                'fullname.required' => 'Full name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email format is not valid.',
                'email.unique' => 'Email is already in use.',
                'phone.required' => 'Phone number is required.',
                'role_id.required' => 'Role is required.',
                'role_id.exists' => 'The selected role is invalid.',
            ]
        );

        /**
         * Hash password jika ada input password baru, atau gunakan password lama jika input kosong
         * 
         * Logika:
         * - Jika $validatedData['password'] ada/terisi: encrypt password baru dengan bcrypt
         * - Jika $validatedData['password'] kosong: ambil password lama dari database berdasarkan user ID
         * 
         * @param string $id User ID untuk mencari data user saat ini
         * @return string Password yang sudah di-hash atau password lama dari database
         */
        $vallidatedData['password'] = $validatedData['password'] ? bcrypt($validatedData['password']) : User::findOrFail($id)->password;
        $user = User::findOrFail($id);
        $user->update($validatedData);
        return redirect()->route('users.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
