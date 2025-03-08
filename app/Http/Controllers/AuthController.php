<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginRegister()
    {
        return view('auth.login-register');
    }

    /**
     * Reload captcha
     */
    public function reloadCaptcha()
    {
        return response()->json([
            'captcha' => captcha_img('math')
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            if (Auth::user()->is_active != 1) {
                Auth::logout();

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akun belum divalidasi BEM'
                    ]);
                }

                return back()->with('error-swal', 'Akun belum divalidasi BEM');
            }

            $user = Auth::user();
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_role', $user->role);

            $request->session()->regenerate();

            // Redirect berdasarkan role
            $redirectUrl = ($user->role == 'user') ? route('user.dashboard.index') : route('admin.dashboard.index');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => $redirectUrl
                ]);
            }

            return redirect()->intended($redirectUrl)->with('success', 'Login berhasil!');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.'
            ]);
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }


    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'fullName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'contact' => ['required', 'string', 'max:255'],
                'password' => ['required', Password::min(6)],
                // 'captcha' => ['required', 'captcha'],
            ]);

            $result = DB::transaction(function () use ($validated) {
                $user = User::create([
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'is_active' => 0,
                    'password' => Hash::make($validated['password']),
                    'role' => 'user',
                ]);

                Profil::create([
                    'user_id' => $user->id,
                    'nama' => $validated['fullName'],
                    'kontak' => $validated['contact'],
                ]);

                return true;
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil! Silakan login.'
                ]);
            }

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registrasi gagal: ' . $e->getMessage()
                ]);
            }

            return back()->with('error-swal', 'Registrasi gagal: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
