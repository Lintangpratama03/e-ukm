<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KelolaProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profil = Profil::where('user_id', $user->id)->firstOrFail();

        return view('admin.kelola-profil', compact('user', 'profil'));
    }

    /**
     * Update profil user dan profil tambahan.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profil = Profil::where('user_id', $user->id)->firstOrFail();

        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'kontak' => 'nullable|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update User
        $user->update([
            'email' => $request->email,
        ]);

        // Update Profil
        $profil->update([
            'nama' => $request->name,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'deskripsi' => $request->deskripsi,
            'kontak' => $request->kontak,
        ]);

        // Update Logo jika ada file baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($profil->logo) {
                Storage::delete('public/' . $profil->logo);
            }

            // Simpan logo baru
            $path = $request->file('logo')->store('profil', 'public');
            $profil->update(['logo' => $path]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update Password User
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama sesuai
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->with('error', 'Password lama salah!');
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }
}
