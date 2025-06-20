<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Tempat;
use App\Models\JadwalTempat;
use App\Models\TbLembarPengesahan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class KelolaJadwalController extends Controller
{
    public function index()
    {
        $tempat = Tempat::all();
        return view('admin.bem.kelola-jadwal', compact('tempat'));
    }

    public function getData()
    {
        $jadwal = Jadwal::with('tempats')->orderBy('created_at', 'desc')->get();
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
                    <a href="' . route('admin.jadwal.show', $row->id) . '" class="btn btn-sm btn-info">
                        <i class="dripicons-preview"></i>
                    </a>';
            })
            ->rawColumns(['status', 'status_ttd', 'action'])
            ->make(true);
    }
    public function show($id)
    {
        $jadwal = Jadwal::with('tempats', 'pengesahan')->findOrFail($id);
        return view('admin.bem.detail-jadwal', compact('jadwal'));
    }
    public function validasi(Request $request, $id)
    {
        $request->validate([
            'status_validasi' => 'required|in:divalidasi,ditolak',
            'catatan_validasi' => 'nullable|string|max:255',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'status_validasi' => $request->status_validasi,
            'catatan_validasi' => $request->catatan_validasi,
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
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
        // dd($request->all());
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'proposal' => 'nullable|file|mimes:pdf',
            'nama_kegiatan' => 'required|string|max:255',
            'sasaran' => 'required|string',
            'program' => 'required|string',
            'indikator_kerja' => 'required|string',
        ]);
        if ($request->hasFile('proposal')) {
            if ($jadwal->proposal) {
                Storage::disk('public')->delete($jadwal->proposal);
            }
            $jadwal->proposal = $request->file('proposal')->store('proposal', 'public');
        }
        TbLembarPengesahan::create([
            'jadwal_id' => $id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'sasaran' => $request->sasaran,
            'program' => $request->program,
            'indikator_kerja' => $request->indikator_kerja,
            'peserta' => $request->volume,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'jumlah_dana' => str_replace('.', '', $request->jumlah_dana),
            'sumber_dana' => $request->sumber_dana,
            'dpk' => $request->dpk,
            'ketua_pelaksana' => $request->ketua_pelaksana,
            'nim_ketua_pelaksana' => $request->nim_ketua_pelaksana,
        ]);
        $jadwal->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah.');
    }
    public function generatePdf($id)
    {
        $jadwal = Jadwal::with('tempats')->findOrFail($id);
        $paraf = Anggota::where('jabatan', 'ketua')
            ->where('user_id', 1)
            ->value('paraf');
        if ($paraf) {
            $paraf = public_path("storage/$paraf");
        } else {
            $paraf = null;
        }
        $lembarPengesahan = TbLembarPengesahan::where('jadwal_id', $id)->first();
        if (!$lembarPengesahan) {
            return redirect()->back()->with('error', 'Data lembar pengesahan tidak ditemukan.');
        }
        try {
            $pdf = Pdf::loadView('admin.pengesahan.lembar_pengesahan', compact('paraf', 'jadwal', 'lembarPengesahan'));
            $filename = 'lembar_pengesahan_' . $jadwal->id . '.pdf';
            $path = 'lembar_pengesahan/' . $filename;
            Storage::disk('public')->put($path, $pdf->output());
            $jadwal->lembar_pengesahan = $path;
            $jadwal->status_ttd = 'berhasil';
            $jadwal->save();
            return redirect()->back()->with('success', 'Lembar Pengesahan berhasil disimpan sebagai PDF.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }
}
