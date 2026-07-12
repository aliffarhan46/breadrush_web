<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('register');
    }

    public function register(Request $request)
    {
        $nama = $request->input('nama');
        $email = $request->input('email');
        $password = $request->input('password');

        // Validasi email gmail
        if (!str_ends_with($email, '@gmail.com')) {
            return back()->with('alert', 'Email harus menggunakan @gmail.com')->withInput();
        }

        // Cek email sudah ada atau belum
        $userExists = User::where('email', $email)->exists();
        if ($userExists) {
            return back()->with('alert', 'Email sudah digunakan!')->withInput();
        }

        // Simpan user
        User::create([
            'nama' => $nama,
            'email' => $email,
            'password_users' => Hash::make($password),
        ]);

        // Jangan login otomatis; arahkan ke login untuk keamanan
        return redirect()->route('login')->with('alert_success', 'Pendaftaran berhasil! Silakan login terlebih dahulu.');
    }

    public function googleRegister(Request $request)
    {
        $nama = $request->query('nama');
        $email = $request->query('email');
        $password = $request->query('password');
        $avatar = $request->query('avatar');

        if (empty($email) || empty($nama)) {
            return redirect()->route('register')->with('alert', 'Pilihan tidak valid!');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'nama' => $nama,
                'email' => $email,
                'password_users' => Hash::make($password ?? 'admin123'),
                'foto_profile' => $avatar,
            ]);
        } else if ($avatar && empty($user->foto_profile)) {
            $user->foto_profile = $avatar;
            $user->save();
        }

        return redirect()->route('login')->with('alert_success', 'Akun Google berhasil disiapkan. Silakan login terlebih dahulu.');
    }

    public function googleLogin(Request $request)
    {
        $email = $request->query('email');
        $nama = $request->query('nama');
        $password = $request->query('password');
        $avatar = $request->query('avatar');

        if (empty($email)) {
            return redirect()->route('login')->with('alert', 'Pilihan tidak valid!');
        }

        // Cek email sudah ada atau belum
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($avatar && empty($user->foto_profile)) {
                $user->foto_profile = $avatar;
                $user->save();
            }
            return redirect()->route('login')->with('alert_success', 'Akun Google sudah terdaftar. Silakan login terlebih dahulu.');
        } else {
            if (!empty($nama)) {
                $user = User::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password_users' => Hash::make($password ?? 'admin123'),
                    'foto_profile' => $avatar,
                ]);
                return redirect()->route('login')->with('alert_success', 'Akun Google berhasil dibuat. Silakan login terlebih dahulu.');
            }
            return redirect()->route('login')->with('alert', 'Akun Google tidak ditemukan!');
        }
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password_users)) {
            Auth::login($user);
            return redirect()->route('home')->with('alert_success', 'Login berhasil!');
        }

        return back()->with('alert', 'Email atau password salah!')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('alert_success', 'Berhasil logout!');
    }
}
