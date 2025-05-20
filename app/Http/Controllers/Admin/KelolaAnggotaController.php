<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class KelolaAnggotaController extends Controller
{
    public function index()
    {
        return view('admin.anggota');
    }

    public function getAnggota()
    {
        $user = Auth::user();
        $data = Anggota::where('user_id', $user->id)->get();
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '">
                            <i class="dripicons-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                            <i class="dripicons-trash"></i>
                        </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'image|nullable'
        ]);

        $filePath = $request->file('foto') ? $request->file('foto')->store('uploads', 'public') : null;
        $user = Auth::user();

        Anggota::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
            'no_hp' => $request->no_hp,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'foto' => $filePath
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $anggota = Anggota::find($request->anggota_id);
        // dd($anggota);
        $filePath = $anggota->foto;
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('uploads', 'public');
        }

        $anggota->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jabatan' => $request->jabatan,
            'bidang' => $request->bidang,
            'no_hp' => $request->no_hp,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'foto' => $filePath
        ]);

        return response()->json(['success' => true]);
    }


    public function edit($id)
    {
        return response()->json(Anggota::find($id));
    }
    public function delete($id)
    {
        Anggota::destroy($id);
        return response()->json(['success' => true]);
    }
}
