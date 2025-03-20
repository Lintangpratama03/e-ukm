<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Profil;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalKegiatan = Jadwal::count();
        $kegiatanBulanIni = Jadwal::where('status_validasi', 'divalidasi')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();
        $kegiatanTahunIni = Jadwal::where('status_validasi', 'divalidasi')
            ->whereYear('created_at', $tahunIni)
            ->count();
        $kegiatanValidasi = Jadwal::where('status_validasi', 'divalidasi')
            ->count();

        return view('admin.bem.dashboard', compact(
            'totalKegiatan',
            'kegiatanBulanIni',
            'kegiatanTahunIni',
            'kegiatanValidasi'
        ));
    }

    public function getUkmActivityData()
    {
        $dataAktivitasUkm = User::with('profil')
            ->where('role', 'user')
            ->get()
            ->map(function ($user) {
                return [
                    'ukm_name' => $user->profil->nama ?? 'Nama UKM tidak tersedia',
                    'total_activities' => Jadwal::where('user_id', $user->id)->count()
                ];
            })
            ->sortByDesc('total_activities')
            ->values();

        return response()->json($dataAktivitasUkm);
    }

    public function getUkmDataTable(Request $request)
    {
        if ($request->ajax()) {
            $dataUkm = User::with('profil')
                ->where('role', 'user')
                ->get();

            return DataTables::of($dataUkm)
                ->addColumn('ukm_name', function ($user) {
                    return $user->profil->nama ?? 'Nama UKM tidak tersedia';
                })
                ->addColumn('total_activities', function ($user) {
                    return Jadwal::where('user_id', $user->id)->count();
                })
                ->addColumn('ukm_details', function ($user) {
                    return '<button class="btn btn-sm btn-info view-details" data-id="' . $user->id . '">Lihat Detail</button>';
                })
                ->rawColumns(['ukm_details'])
                ->make(true);
        }
    }

    public function getDetailKegiatan(Request $request)
    {
        $kegiatan = Jadwal::with('tempats')
            ->where('user_id', $request->id)
            ->select(['id', 'nama_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'status_validasi', 'user_id'])
            ->get();
        return DataTables::of($kegiatan)
            ->addColumn('tempat', function ($item) {
                $tempat = $item->tempats->pluck('nama_tempat')->join(', ');
                return $tempat ?: 'Tidak ada tempat terdaftar';
            })
            ->addColumn('tanggal', function ($item) {
                return Carbon::parse($item->tanggal_mulai)->format('d/m/Y') . ' - ' .
                    Carbon::parse($item->tanggal_selesai)->format('d/m/Y');
            })
            ->make(true);
    }
}
