<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Profil;
use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $hariIni = Carbon::now();
        $kegiatanBulanIni = Jadwal::where('status_validasi', 'divalidasi')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();
        $kegiatanTahunIni = Jadwal::where('status_validasi', 'divalidasi')
            ->whereYear('created_at', $tahunIni)
            ->count();
        $kegiatanHariIni = Jadwal::where('status_validasi', 'divalidasi')
            ->where('created_at', $hariIni)
            ->count();
        $events = Jadwal::with('tempats', 'ukm')
            ->where('status_validasi', 'divalidasi')
            ->where('tanggal_mulai', '>=', now())
            ->get();
        $ukmProfiles = Profil::all();
        return view('landing-page.home', compact(
            'kegiatanHariIni',
            'kegiatanBulanIni',
            'kegiatanTahunIni',
            'events',
            'ukmProfiles'
        ));
    }
    public function profilUkm($id)
    {
        $ukm = Profil::with(['jadwal.dokumentasi', 'jadwal.tempats'])->where('user_id', $id)->first();
        return view('landing-page.profil-ukm', compact('ukm'));
    }

    /**
     * Get events for the calendar
     */
    public function getEvents()
    {
        $events = Jadwal::with('tempats', 'ukm')
            ->where('status_validasi', 'divalidasi')
            ->get();

        $data = [];

        foreach ($events as $event) {
            $data[] = [
                'title' => $event->nama_kegiatan,
                'start' => $event->tanggal_mulai,
                'end' => $event->tanggal_selesai,
                'color' => 'rgb(26, 115, 232)',
                'extendedProps' => [
                    'ukm' => $event->ukm->nama,
                    'tempat' => $event->tempats->pluck('nama_tempat')->implode(', '),
                    'tanggalMulai' => Carbon::parse($event->tanggal_mulai)->format('d M Y'),
                    'tanggalSelesai' => Carbon::parse($event->tanggal_selesai)->format('d M Y'),
                    'deskripsi' => $event->deskripsi
                ],
                'description' => $event->deskripsi
            ];
        }

        return response()->json($data);
    }

    public function getUkmEvents($id)
    {
        $events = Jadwal::with('tempats')
            ->where('user_id', $id)
            ->where('status_validasi', 'divalidasi')
            ->get();

        $data = [];

        foreach ($events as $event) {
            $data[] = [
                'title' => $event->nama_kegiatan,
                'start' => $event->tanggal_mulai,
                'end' => $event->tanggal_selesai,
                'color' => 'rgb(26, 115, 232)',
                'extendedProps' => [
                    'tempat' => $event->tempats->pluck('nama_tempat')->implode(', '),
                    'tanggalMulai' => Carbon::parse($event->tanggal_mulai)->format('d M Y'),
                    'tanggalSelesai' => Carbon::parse($event->tanggal_selesai)->format('d M Y'),
                    'deskripsi' => $event->deskripsi
                ],
                'description' => $event->deskripsi
            ];
        }

        return response()->json($data);
    }

    public function Jadwal()
    {
        $jadwal = Jadwal::with('tempats', 'ukm')
            ->where('status_validasi', 'divalidasi')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $ukmAktif = Profil::select(
            'tb_profil.*',
            DB::raw('COUNT(tb_jadwal.id) as jumlah_kegiatan'),
            DB::raw('MAX(tb_jadwal.tanggal_mulai) as kegiatan_terakhir')
        )
            ->leftJoin('tb_jadwal', 'tb_profil.user_id', '=', 'tb_jadwal.user_id')
            ->where('tb_jadwal.status_validasi', 'divalidasi')
            ->groupBy(
                'tb_profil.id',
                'tb_profil.user_id',
                'tb_profil.nama',
                'tb_profil.visi',
                'tb_profil.misi',
                'tb_profil.deskripsi',
                'tb_profil.logo',
                'tb_profil.kontak',
                'tb_profil.created_at',
                'tb_profil.updated_at'
            )
            ->orderBy('jumlah_kegiatan', 'desc')
            ->take(10)
            ->get();

        $kegiatanPerBulan = Jadwal::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('YEAR(tanggal_mulai) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->where('status_validasi', 'divalidasi')
            ->whereYear('tanggal_mulai', Carbon::now()->year)
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $jumlahKegiatanPerBulan = [];

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = $namaBulan[$i];
            $jumlahKegiatanPerBulan[] = 0;
        }

        foreach ($kegiatanPerBulan as $data) {
            $jumlahKegiatanPerBulan[$data->bulan - 1] = $data->jumlah;
        }

        $kegiatanPerUKM = Jadwal::select(
            'tb_profil.nama',
            DB::raw('COUNT(tb_jadwal.id) as jumlah')
        )
            ->join('tb_profil', 'tb_jadwal.user_id', '=', 'tb_profil.user_id')
            ->where('tb_jadwal.status_validasi', 'divalidasi')
            ->groupBy('tb_profil.nama')
            ->orderBy('jumlah', 'desc')
            ->get();

        $namaUkm = $kegiatanPerUKM->pluck('nama')->toArray();
        $jumlahKegiatanUkm = $kegiatanPerUKM->pluck('jumlah')->toArray();

        return view('landing-page.jadwal', compact(
            'jadwal',
            'ukmAktif',
            'bulan',
            'jumlahKegiatanPerBulan',
            'namaUkm',
            'jumlahKegiatanUkm'
        ));
    }
}
