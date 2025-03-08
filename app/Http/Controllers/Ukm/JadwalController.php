<?php

namespace App\Http\Controllers\Ukm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Tempat;
use App\Models\JadwalTempat;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $tempat = Tempat::all();
        return view('admin.ukm.kelola-jadwal', compact('tempat'));
    }

    public function getData()
    {
        $jadwal = Jadwal::with('tempats')->where('user_id', Auth::id())->get();
        return DataTables::of($jadwal)
            ->addIndexColumn()
            ->addColumn('waktu', function ($row) {
                return date('d-m-Y', strtotime($row->tanggal_mulai)) . ' sampai ' . date('d-m-Y', strtotime($row->tanggal_selesai));
            })
            ->addColumn('tempat', function ($row) {
                return $row->tempats->pluck('nama_tempat')->implode(', ');
            })
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-' . ($row->status_validasi == 'divalidasi' ? 'success' : 'warning') . '">' . ucfirst($row->status_validasi) . '</span>';
            })
            ->addColumn('status_ttd', function ($row) {
                return '<span class="badge bg-' . ($row->status_ttd == 'berhasil' ? 'success' : 'secondary') . '">' . ucfirst($row->status_ttd) . '</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('user.jadwal.show', $row->id) . '" class="btn btn-sm btn-info">
                        <i class="dripicons-preview"></i>
                    </a>';
            })
            ->rawColumns(['status', 'status_ttd', 'action'])
            ->make(true);
    }
    public function show($id)
    {
        $jadwal = Jadwal::with('tempats')->findOrFail($id);
        return view('admin.ukm.detail-jadwal', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tempat_id' => 'required|array',
        ]);
        $jadwalBentrok = Jadwal::whereHas('tempats', function ($query) use ($request) {
            $query->whereIn('tempat_id', $request->tempat_id);
        })
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($jadwalBentrok) {
            return response()->json([
                'status' => 'error',
                'message' => "Tempat yang dipilih sudah dipakai dalam rentang tanggal tersebut."
            ], 400);
        }
        $jadwal = Jadwal::create([
            'user_id' => Auth::id(),
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        $jadwal->tempats()->attach($request->tempat_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil ditambahkan.'
        ]);
    }



    public function edit($id)
    {
        $jadwal = Jadwal::with('tempat')->findOrFail($id);
        return response()->json($jadwal);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tempat_id' => 'required|array',
        ]);

        $jadwal->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        $jadwal->tempat()->sync($request->tempat_id);

        return response()->json(['message' => 'Jadwal berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }

    public function uploadProposal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'proposal' => 'nullable|file|mimes:pdf|max:2048',
            'lembar_pengesahan' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        if ($request->hasFile('proposal')) {
            if ($jadwal->proposal) {
                Storage::disk('public')->delete($jadwal->proposal);
            }
            $jadwal->proposal = $request->file('proposal')->store('proposal', 'public');
        }

        if ($request->hasFile('lembar_pengesahan')) {
            if ($jadwal->lembar_pengesahan) {
                Storage::disk('public')->delete($jadwal->lembar_pengesahan);
            }
            $jadwal->lembar_pengesahan = $request->file('lembar_pengesahan')->store('lembar_pengesahan', 'public');
        }

        $jadwal->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah.');
    }
}
