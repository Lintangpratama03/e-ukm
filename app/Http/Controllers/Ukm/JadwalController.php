<?php

namespace App\Http\Controllers\Ukm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Tempat;
use App\Models\JadwalTempat;
use App\Models\Profil;
use App\Models\Proposal;
use App\Models\TbLembarPengesahan;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $jadwal = Jadwal::with('tempats', 'pengesahan')->findOrFail($id);
        // dd($jadwal);
        return view('admin.ukm.detail-jadwal', compact('jadwal'));
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

        $Profil = Profil::where('user_id', Auth::id())->first();
        // dd($Profil);
        $nama = $Profil->nama;
        $jadwal->tempats()->attach($request->tempat_id);
        $tempat = Tempat::whereIn('id', $request->tempat_id)->pluck('nama_tempat')->first();
        $no = Profil::where('user_id', 1)->value('kontak');
        // dd($no);
        $message =
            "* Notifikasi Jadwal Baru UKM.*\n\n"
            . "*Detail Pengajuan:*\n"
            . "*Nama UKM*: $nama\n"
            . "*Nama Kegiatan*: $request->nama_kegiatan\n"
            . "*Tanggal Mulai:* $request->tanggal_mulai\n"
            . "*Tanggal Selesai:* $request->tanggal_selesai\n"
            . "*Tempat:* $tempat\n"
            . "Silahkan cek di aplikasi untuk detail lebih lanjut.\n\n";
        $sendwa = $this->sendWa($no, $message);
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil ditambahkan.'
        ]);
    }

    public function sendWa($receiver, $message)
    {
        try {
            $token = "M9kpxFexDAbVG5CzcmLJ";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $receiver,
                    'message' => $message,
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token
                ),
            ));

            $response = curl_exec($curl);
            // dd($response);
            curl_close($curl);
            // echo $response; //log response fonnte
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
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
            'nama_kegiatan' => 'required|string|max:255',
            'sasaran' => 'required|string',
            'program' => 'required|string',
            'indikator_kerja' => 'required|string',
        ]);
        $lembarPengesahan = TbLembarPengesahan::where('jadwal_id', $id)->first();
        if ($lembarPengesahan && $jadwal->status_ttd === 'berhasil') {
            return redirect()->back()->with('error', 'Dokumen tidak dapat diperbarui karena sudah berhasil ditandatangani.');
        }
        if ($request->hasFile('proposal')) {
            if ($jadwal->proposal) {
                Storage::disk('public')->delete($jadwal->proposal);
            }
            $jadwal->proposal = $request->file('proposal')->store('proposal', 'public');
        }
        if ($lembarPengesahan) {
            $lembarPengesahan->update([
                'nama_kegiatan' => $request->nama_kegiatan,
                'sasaran' => $request->sasaran,
                'program' => $request->program,
                'indikator_kerja' => $request->indikator_kerja,
                'peserta' => $request->volume,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'jumlah_dana' => str_replace('.', '', $request->jumlah_dana),
                'dpk' => $request->dpk,
                'ketua_pelaksana' => $request->ketua_pelaksana,
                'nim_ketua_pelaksana' => $request->nim_ketua_pelaksana,
            ]);
        } else {
            TbLembarPengesahan::create([
                'jadwal_id' => $id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'sasaran' => $request->sasaran,
                'program' => $request->program,
                'indikator_kerja' => $request->indikator_kerja,
                'peserta' => $request->volume,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'jumlah_dana' => str_replace('.', '', $request->jumlah_dana),
                'dpk' => $request->dpk,
                'ketua_pelaksana' => $request->ketua_pelaksana,
                'nim_ketua_pelaksana' => $request->nim_ketua_pelaksana,
            ]);
            $jadwal->status_ttd = 'proses';
        }
        $jadwal->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah atau diperbarui.');
    }

    public function generatePdf($id)
    {
        $jadwal = Jadwal::with('tempats')->findOrFail($id);
        $lembarPengesahan = TbLembarPengesahan::where('jadwal_id', $id)->first();
        if (!$lembarPengesahan) {
            return redirect()->back()->with('error', 'Data lembar pengesahan tidak ditemukan.');
        }
        try {
            $pdf = Pdf::loadView('admin.pengesahan.lembar_pengesahan', compact('jadwal', 'lembarPengesahan'));
            $filename = 'lembar_pengesahan_' . $jadwal->id . '.pdf';
            $path = 'lembar_pengesahan/' . $filename;
            Storage::disk('public')->put($path, $pdf->output());
            $jadwal->lembar_pengesahan = $path;
            $jadwal->save();
            return redirect()->back()->with('success', 'Lembar Pengesahan berhasil disimpan sebagai PDF.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }


    public function formProposal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $proposal = Proposal::where('jadwal_id', $id)->first();
        // dd($jadwal, $proposal);
        return view('admin.ukm.proposal.form', compact('jadwal', 'proposal'));
    }

    public function storeProposal(Request $request, $id)
    {
        // dd(1);
        $jadwal = Jadwal::findOrFail($id);


        $dasar_kegiatan = array_filter(explode("\n", $request->dasar_kegiatan));
        $metode_pelaksanaan = array_filter(explode("\n", $request->metode_pelaksanaan));
        $tahapan_pelaksanaan = array_filter(explode("\n", $request->tahapan_pelaksanaan));


        $materi_kegiatan = [];
        if ($request->has('materi_nama')) {
            foreach ($request->materi_nama as $key => $nama) {
                if (!empty($nama)) {
                    $materi_kegiatan[] = [
                        'nama' => $nama,
                        'judul' => $request->materi_judul[$key] ?? '',
                        'pemateri' => $request->materi_pemateri[$key] ?? ''
                    ];
                }
            }
        }


        $susunan_acara = [];
        if ($request->has('acara_waktu')) {
            foreach ($request->acara_waktu as $key => $waktu) {
                if (!empty($waktu)) {
                    $susunan_acara[] = [
                        'waktu' => $waktu,
                        'kegiatan' => $request->acara_kegiatan[$key] ?? '',
                        'pengisi' => $request->acara_pengisi[$key] ?? ''
                    ];
                }
            }
        }


        $anggaran_belanja = [];
        if ($request->has('anggaran_uraian')) {
            foreach ($request->anggaran_uraian as $key => $uraian) {
                if (!empty($uraian)) {
                    $qty = (int)($request->anggaran_qty[$key] ?? 0);
                    $total_barang = (int)($request->anggaran_total_barang[$key] ?? 0);
                    $harga = (int)str_replace('.', '', $request->anggaran_harga[$key] ?? 0);
                    $total = $qty * $harga;

                    $anggaran_belanja[] = [
                        'akun' => $request->anggaran_akun[$key] ?? '',
                        'kategori' => $request->anggaran_kategori[$key] ?? '',
                        'uraian' => $uraian,
                        'rincian' => $request->anggaran_rincian[$key] ?? '',
                        'total_barang' => $total_barang,
                        'qty' => $qty,
                        'harga_satuan' => $harga,
                        'total_harga' => $total,
                        'harga_satuan_format' => 'Rp' . number_format($harga, 0, ',', '.'),
                        'total_harga_format' => 'Rp' . number_format($total, 0, ',', '.')
                    ];
                }
            }
        }

        $susunan_kepanitiaan = [];
        if ($request->has('panitia_nama')) {
            foreach ($request->panitia_nama as $key => $nama) {
                if (!empty($nama)) {
                    $susunan_kepanitiaan[] = [
                        'nama' => $nama,
                        'nim' => $request->panitia_nim[$key] ?? '',
                        'prodi' => $request->panitia_prodi[$key] ?? '',
                        'jabatan' => $request->panitia_jabatan[$key] ?? ''
                    ];
                }
            }
        }

        $bulan_headers = array_map('trim', explode(',', $request->bulan_headers));
        $jadwal_kegiatan = [];
        if ($request->has('jadwal_nama')) {
            foreach ($request->jadwal_nama as $key => $nama) {
                if (!empty($nama)) {
                    $timeline_string = $request->jadwal_timeline[$key] ?? '0,0,0,0,0,0,0,0,0,0,0,0';
                    $timeline_array = array_map('intval', explode(',', $timeline_string));

                    $jadwal_kegiatan[] = [
                        'nama' => $nama,
                        'timeline' => $timeline_array
                    ];
                }
            }
        }
        $proposalData = [
            'jadwal_id' => $id,
            'kegiatan_singkat' => $request->kegiatan_singkat,
            'kegiatan_lengkap' => $request->kegiatan_lengkap,
            'nama_penyusun' => $request->nama_penyusun,
            'nim_penyusun' => $request->nim_penyusun,
            'nama_institusi' => $request->nama_institusi,
            'tahun' => $request->tahun,
            'dasar_kegiatan' => $dasar_kegiatan,
            'gambaran_umum' => $request->gambaran_umum,
            'penerima_manfaat' => $request->penerima_manfaat,
            'metode_pelaksanaan' => $metode_pelaksanaan,
            'tahapan_pelaksanaan' => $tahapan_pelaksanaan,
            'deskripsi_waktu_pelaksanaan' => $request->deskripsi_waktu_pelaksanaan,
            'bulan_headers' => $bulan_headers,
            'jadwal_kegiatan' => $jadwal_kegiatan,
            'kurun_waktu_pencapaian' => $request->kurun_waktu_pencapaian,
            'deskripsi_materi_kegiatan' => $request->deskripsi_materi_kegiatan,
            'materi_kegiatan' => $materi_kegiatan,
            'hari_tanggal_acara' => $request->hari_tanggal_acara,
            'susunan_acara' => $susunan_acara,
            'deskripsi_biaya' => $request->deskripsi_biaya,
            'judul_anggaran' => $request->judul_anggaran,
            'anggaran_belanja' => $anggaran_belanja,
            'total_anggaran' => str_replace('.', '', $request->total_anggaran),
            'judul_kepanitiaan' => $request->judul_kepanitiaan,
            'susunan_kepanitiaan' => $susunan_kepanitiaan
        ];

        $proposal = Proposal::updateOrCreate(
            ['jadwal_id' => $id],
            $proposalData
        );
        $this->generateProposalPdf($id);
        return redirect()->route('user.jadwal.show', $id)
            ->with('success', 'Data proposal berhasil disimpan.');
    }

    public function generateProposalPdf($id)
    {
        $jadwal = Jadwal::with('tempats')->findOrFail($id);
        $proposal = Proposal::where('jadwal_id', $id)->first();
        // dd($jadwal);
        if (!$proposal) {
            return redirect()->back()->with('error', 'Data proposal tidak ditemukan.');
        }
        $logo = public_path("assets/images/logopolinema.png");
        try {
            $pdf = Pdf::loadView('admin.proposal.proposal', compact('logo', 'jadwal', 'proposal'));
            $filename = 'proposal_' . $jadwal->id . '.pdf';
            $path = 'proposal/' . $filename;

            Storage::disk('public')->put($path, $pdf->output());

            $jadwal->proposal = $path;
            $jadwal->save();

            return redirect()->back()->with('success', 'Proposal berhasil disimpan sebagai PDF.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }
}
