<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Perbarui data profil pengguna (Nama, Password, Foto Profil).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'foto_profile.image' => 'File harus berupa gambar.',
            'foto_profile.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'foto_profile.max' => 'Ukuran gambar maksimal adalah 2MB.'
        ]);

        // Cari user di database menggunakan instance model agar save() berfungsi dengan benar
        $dbUser = User::find($user->id_users);
        if (!$dbUser) {
            return back()->with('alert', 'Pengguna tidak ditemukan.');
        }

        $dbUser->nama = $request->input('nama');

        // Ganti password jika diisi
        if ($request->filled('password')) {
            $dbUser->password_users = Hash::make($request->input('password'));
        }

        // Tangani unggahan foto profil
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan file ke public/uploads/avatars
            $destinationPath = public_path('uploads/avatars');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);

            // Hapus file lama jika ada dan bukan gambar default/eksternal
            if ($dbUser->foto_profile && !str_starts_with($dbUser->foto_profile, 'http') && file_exists(public_path($dbUser->foto_profile))) {
                @unlink(public_path($dbUser->foto_profile));
            }

            $dbUser->foto_profile = 'uploads/avatars/' . $filename;
        }

        $dbUser->save();

        // Re-authenticate user to update session
        Auth::login($dbUser);

        return redirect()->route('profile')->with('alert_success', 'Profil berhasil diperbarui!');
    }
}
