<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tempat;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TempatController extends Controller
{
    public function index()
    {
        return view('admin.bem.kelola-tempat');
    }

    public function getData()
    {
        $tempat = Tempat::all();
        return DataTables::of($tempat)
            ->addIndexColumn()
            ->addColumn('foto', function ($row) {
                return $row->foto ? '<img src="' . asset('storage/' . $row->foto) . '" width="50">' : 'No Image';
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-warning btn-edit" data-id="' . $row->id . '">
                            <i class="dripicons-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                            <i class="dripicons-trash"></i>
                        </button>';
            })
            ->rawColumns(['foto', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('tempat', 'public');
        }

        Tempat::create($data);

        return response()->json(['message' => 'Tempat berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $tempat = Tempat::findOrFail($id);

        $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($tempat->foto) {
                Storage::disk('public')->delete($tempat->foto);
            }
            $data['foto'] = $request->file('foto')->store('tempat', 'public');
        }

        $tempat->update($data);

        return response()->json(['message' => 'Tempat berhasil diperbarui']);
    }
    public function edit($id)
    {
        return response()->json(Tempat::find($id));
    }
    public function destroy($id)
    {
        $tempat = Tempat::findOrFail($id);
        if ($tempat->foto) {
            Storage::disk('public')->delete($tempat->foto);
        }
        $tempat->delete();

        return response()->json(['message' => 'Tempat berhasil dihapus']);
    }
}
