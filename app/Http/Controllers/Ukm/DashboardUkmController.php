<?php

namespace App\Http\Controllers\Ukm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Profil;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class DashboardUkmController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $query = Auth::user()->role === 'admin' ? Jadwal::query() : Jadwal::where('user_id', $user_id);
        $totalKegiatan = $query->count();
        $kegiatanValidasi = (clone $query)->where('status_validasi', 'divalidasi')->count();
        $kegiatanBulanIni = (clone $query)->where('status_validasi', 'divalidasi')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();
        $kegiatanTahunIni = (clone $query)->where('status_validasi', 'divalidasi')
            ->whereYear('created_at', $tahunIni)
            ->count();
        $upcomingKegiatan = (clone $query)
            ->with('tempats')
            ->where('tanggal_mulai', '>=', Carbon::now())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();
        $monthlyActivity = $this->getMonthlyActivityData($user_id, $tahunIni);

        return view('admin.ukm.dashboard', compact(
            'totalKegiatan',
            'kegiatanBulanIni',
            'kegiatanTahunIni',
            'kegiatanValidasi',
            'upcomingKegiatan',
            'monthlyActivity'
        ));
    }

    private function getMonthlyActivityData($user_id = null, $year = null)
    {
        $year = $year ?? Carbon::now()->year;
        $query = Jadwal::query();
        if ($user_id && Auth::user()->role === 'user') {
            $query->where('user_id', $user_id);
        }
        $monthlyData = $query->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status_validasi = "divalidasi" THEN 1 ELSE 0 END) as validated')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $formattedData = [];
        $monthNames = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        foreach (range(1, 12) as $month) {
            $monthData = $monthlyData->firstWhere('month', $month);
            $formattedData[] = [
                'month' => $monthNames[$month],
                'monthNum' => $month,
                'total' => $monthData ? $monthData->total : 0,
                'validated' => $monthData ? $monthData->validated : 0,
                'pending' => $monthData ? ($monthData->total - $monthData->validated) : 0
            ];
        }

        return $formattedData;
    }

    public function getUkmActivityData()
    {
        $dataAktivitasUkm = User::with('profil')
            ->where('role', 'user')
            ->get()
            ->map(function ($user) {
                return [
                    'ukm_name' => $user->profil->nama ?? 'Nama UKM tidak tersedia',
                    'total_activities' => Jadwal::where('user_id', $user->id)->count(),
                    'validated_activities' => Jadwal::where('user_id', $user->id)
                        ->where('status_validasi', 'divalidasi')
                        ->count()
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
                ->addColumn('validated_activities', function ($user) {
                    return Jadwal::where('user_id', $user->id)
                        ->where('status_validasi', 'divalidasi')
                        ->count();
                })
                ->addColumn('upcoming_activities', function ($user) {
                    return Jadwal::where('user_id', $user->id)
                        ->where('tanggal_mulai', '>=', Carbon::now())
                        ->count();
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
        $user_id = $request->id;
        $kegiatan = Jadwal::with('tempats')
            ->where('user_id', $user_id)
            ->select(['id', 'nama_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'status_validasi', 'user_id'])
            ->get();

        $data = [];
        foreach ($kegiatan as $item) {
            $tempat = $item->tempats->pluck('nama_tempat')->join(', ');
            $data[] = [
                'nama_kegiatan' => $item->nama_kegiatan,
                'tanggal' => Carbon::parse($item->tanggal_mulai)->format('d/m/Y') . ' - ' .
                    Carbon::parse($item->tanggal_selesai)->format('d/m/Y'),
                'tempat' => $tempat ?: 'Tidak ada tempat terdaftar',
                'status_validasi' => $item->status_validasi
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getUserMonthlyActivityData(Request $request)
    {
        $user_id = $request->id;
        $year = $request->year ?? Carbon::now()->year;

        $monthlyData = $this->getMonthlyActivityData($user_id, $year);

        return response()->json($monthlyData);
    }

    public function getUpcomingEvents()
    {
        $user_id = Auth::id();
        $query = Auth::user()->role === 'admin' ? Jadwal::query() : Jadwal::where('user_id', $user_id);

        $upcomingEvents = $query->with('tempats')
            ->where('tanggal_mulai', '>=', Carbon::now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'nama_kegiatan' => $event->nama_kegiatan,
                    'tanggal_mulai' => Carbon::parse($event->tanggal_mulai)->format('d M Y'),
                    'tanggal_selesai' => Carbon::parse($event->tanggal_selesai)->format('d M Y'),
                    'tempat' => $event->tempats->pluck('nama_tempat')->join(', ') ?: 'Tidak ada tempat terdaftar',
                    'status' => $event->status_validasi,
                    'days_remaining' => Carbon::now()->diffInDays(Carbon::parse($event->tanggal_mulai))
                ];
            });

        return response()->json($upcomingEvents);
    }
    public function getData(Request $request)
    {
        $user_id = Auth::id();
        $query = Auth::user()->role === 'admin' ? Jadwal::query() : Jadwal::where('user_id', $user_id);

        // Apply filters from request
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('tanggal_mulai', $request->year);
        }

        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('tanggal_mulai', $request->month);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status_validasi', $request->status);
        }

        $query->with('tempats');

        return DataTables::of($query)
            ->addColumn('waktu', function ($jadwal) {
                return Carbon::parse($jadwal->tanggal_mulai)->format('d/m/Y') . ' - ' .
                    Carbon::parse($jadwal->tanggal_selesai)->format('d/m/Y');
            })
            ->addColumn('tempat', function ($jadwal) {
                return $jadwal->tempats->pluck('nama_tempat')->join(', ') ?: 'Tidak ada tempat terdaftar';
            })
            ->addColumn('status', function ($jadwal) {
                if ($jadwal->status_validasi === 'divalidasi') {
                    return '<span class="badge bg-success">Disetujui</span>';
                } elseif ($jadwal->status_validasi === 'ditolak') {
                    return '<span class="badge bg-danger">Ditolak</span>';
                } else {
                    return '<span class="badge bg-warning">Menunggu</span>';
                }
            })
            ->addColumn('action', function ($jadwal) {
                return '<a href="' . route('user.jadwal.show', $jadwal->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
