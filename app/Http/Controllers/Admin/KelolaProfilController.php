<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KelolaProfilController extends Controller
{
    public function index()
    {
        return view('admin.kelola-profil');
    }

    public function data()
    {
        $data = DB::table('tb_profil')->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('logo', function ($row) {
                if ($row->logo) {
                    return '<img src="' . asset('storage/' . $row->logo) . '" width="50">';
                }
                return '-';
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary edit" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete" data-id="' . $row->id . '">Hapus</button>
                ';
            })
            ->rawColumns(['logo', 'aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'kontak' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $logo = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('logo', 'public');
        }

        DB::table('tb_profil')->insert([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'deskripsi' => $request->deskripsi,
            'kontak' => $request->kontak,
            'logo' => $logo,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Profil berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $profil = DB::table('tb_profil')->where('id', $id)->first();
        return response()->json($profil);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'kontak' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profil = DB::table('tb_profil')->where('id', $id)->first();

        $logo = $profil->logo;
        if ($request->hasFile('logo')) {
            if ($logo) {
                Storage::disk('public')->delete($logo);
            }
            $logo = $request->file('logo')->store('logo', 'public');
        }

        DB::table('tb_profil')->where('id', $id)->update([
            'nama' => $request->nama,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'deskripsi' => $request->deskripsi,
            'kontak' => $request->kontak,
            'logo' => $logo,
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $profil = DB::table('tb_profil')->where('id', $id)->first();
        if ($profil->logo) {
            Storage::disk('public')->delete($profil->logo);
        }
        DB::table('tb_profil')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Profil berhasil dihapus']);
    }
}
