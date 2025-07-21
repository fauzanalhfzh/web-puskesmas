<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pasien.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:pasien,nik',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:pasien,email',
            'password' => 'required|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        Pasien::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Jenis_Kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function showLoginForm()
    {
        return view('pasien.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('pasien')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/pendaftaran'); // redirect ke halaman utama
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('pasien')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
