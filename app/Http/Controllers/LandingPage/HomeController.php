<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Profil;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $events = Jadwal::with('tempats', 'ukm')->get();
        $ukmProfiles = Profil::all();
        return view('landing-page.home', compact(
            'kegiatanHariIni',
            'kegiatanBulanIni',
            'kegiatanTahunIni',
            'events',
            'ukmProfiles'
        ));
    }
    public function getEvents()
    {
        $events = Jadwal::with('tempats', 'ukm')->where('status_validasi', 'divalidasi')->get();
        $data = [];

        foreach ($events as $event) {
            $data[] = [
                'title' => $event->nama_kegiatan,
                'start' => $event->tanggal_mulai,
                'end' => $event->tanggal_selesai,
                'color' => 'rgb(253, 13, 13)',
                'extendedProps' => [
                    'ukm' => $event->ukm->nama,
                    'tempat' => $event->tempats->pluck('nama_tempat')->implode(', '),
                    'tanggalMulai' => \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y'),
                    'tanggalSelesai' => \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y'),
                    'deskripsi' => $event->deskripsi
                ],
                'description' => $event->deskripsi
            ];
        }

        return response()->json($data);
    }
}
