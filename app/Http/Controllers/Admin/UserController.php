<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profil;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.bem.kelola-user');
    }

    public function getData()
    {
        $users = User::with('profil')->where('role', 'user')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return $row->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>';
            })
            ->addColumn('action', function ($row) {
                $buttons = '<button class="btn btn-sm btn-info btn-detail" data-id="' . $row->id . '">Detail</button>';
                if ($row->is_active) {
                    $buttons .= ' <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
                } else {
                    $buttons .= ' <button class="btn btn-sm btn-success btn-activate" data-id="' . $row->id . '">Aktifkan</button>';
                }
                return $buttons;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => 0
        ]);

        return response()->json(['message' => 'User berhasil ditambahkan']);
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => 1]);

        return response()->json(['message' => 'User berhasil diaktifkan']);
    }

    public function detail($id)
    {
        $user = User::with('profil')->findOrFail($id);
        return response()->json($user);
    }
}
