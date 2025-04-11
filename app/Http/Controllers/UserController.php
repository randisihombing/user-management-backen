<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Ambil data user yang sedang login
     */
    public function currentUser(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Update profil user yang sedang login (untuk user sendiri)
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->only(['name', 'email']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);
        $user->refresh();

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user,
        ]);
    }

    /**
     * Update profil user lain berdasarkan ID
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);
        $user->refresh();

        return response()->json([
            'message' => 'User berhasil diperbarui',
            'user' => $user,
        ]);
    }

    /**
     * Ambil daftar user, bisa pakai pencarian dan pagination
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return response()->json($users);
    }

    /**
     * Ambil detail user berdasarkan ID
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
}
