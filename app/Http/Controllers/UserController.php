<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // cara agar hanya admin yang bisa mengakses halaman ini
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'username'  => 'required|string|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|string|in:admin,author',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'username'     => $request->username,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
        ]);

        return redirect('/users')->with('success', 'Pengguna berhasil ditambahkan.');
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
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255',
            'username'  => 'required|string|max:255',
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|string|in:admin,author',
        ]);

        $user = User::findOrFail($id);
        if ($request->password) {
            // dd('password baru ada');
            $user->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'username'  => $request->username,
                'password'  => Hash::make($request->password),
                'role'      => $request->role,
            ]);
        }else{
            // dd('password baru tidak ada');
            $user->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'username'  => $request->username,
                'password'  => $request->old_password,
                'role'      => $request->role,
            ]);
        }

        return redirect('/users')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
