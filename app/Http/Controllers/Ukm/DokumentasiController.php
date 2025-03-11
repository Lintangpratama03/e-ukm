<?php

namespace App\Http\Controllers\Ukm;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DokumentasiController extends Controller
{
    public function index()
    {
        return view('admin.ukm.kelola-dokumentasi');
    }

    public function getData()
    {
        $role = Auth::user()->role;
        if ($role == 'admin') {
            $jadwal = Jadwal::with('tempats', 'dokumentasi')->get();
        } else {
            $jadwal = Jadwal::with('tempats', 'dokumentasi')->where('user_id', Auth::id())->get();
        }
        return DataTables::of($jadwal)
            ->addIndexColumn()
            ->addColumn('waktu', function ($row) {
                return date('d-m-Y', strtotime($row->tanggal_mulai)) . ' sampai ' . date('d-m-Y', strtotime($row->tanggal_selesai));
            })
            ->addColumn('tempat', function ($row) {
                return $row->tempats->pluck('nama_tempat')->implode(', ');
            })
            ->addColumn('jumlah_foto', function ($row) {
                return $row->dokumentasi->count();
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('dokumentasi.show', $row->id) . '" class="btn btn-sm btn-info">
                        <i class="dripicons-preview"></i>
                    </a>';
            })
            ->rawColumns(['status', 'status_ttd', 'action'])
            ->make(true);
    }

    public function show($id)
    {
        $role = Auth::user()->role;
        $jadwal = Jadwal::with('tempats', 'dokumentasi')->findOrFail($id);
        return view('admin.ukm.detail-dokumentasi', compact('jadwal', 'role'));
    }

    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengunggah foto kegiatan ini');
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumentasi', $fileName);

            Dokumentasi::create([
                'user_id' => Auth::id(),
                'jadwal_id' => $id,
                'foto' => $fileName,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->back()->with('success', 'Foto berhasil diunggah');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus foto ini');
        }

        // Delete file from storage
        if (Storage::exists('public/dokumentasi/' . $dokumentasi->foto)) {
            Storage::delete('public/dokumentasi/' . $dokumentasi->foto);
        }

        $dokumentasi->delete();
        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }
}
