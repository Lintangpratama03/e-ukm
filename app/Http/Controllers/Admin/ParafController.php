<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ParafController extends Controller
{
    public function index()
    {
        // Get ketua data
        $ketua = Anggota::where('jabatan', 'ketua')->where('user_id', 1)->first();

        return view('admin.bem.paraf-ketua', [
            'ketua' => $ketua
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:tb_anggota,id',
            'signature' => 'required'
        ]);

        try {
            Log::info('Signature data received', [
                'anggota_id' => $request->anggota_id,
                'signature_length' => strlen($request->signature)
            ]);
            $anggota = Anggota::findOrFail($request->anggota_id);
            $signature = $request->signature;
            if (strpos($signature, 'data:image/png;base64,') === 0) {
                $signature = str_replace('data:image/png;base64,', '', $signature);
                $signature = str_replace(' ', '+', $signature);

                $imageName = 'paraf/ketua_' . time() . '.png';
                $imageData = base64_decode($signature);
                if ($imageData === false) {
                    throw new \Exception('Gagal decode data gambar');
                }
                $image = imagecreatefromstring($imageData);
                if (!$image) {
                    throw new \Exception('Gagal membuat gambar dari data');
                }
                imagealphablending($image, false);
                imagesavealpha($image, true);

                ob_start();
                imagepng($image);
                $transparentImageData = ob_get_clean();
                imagedestroy($image);

                if (!Storage::disk('public')->put($imageName, $transparentImageData)) {
                    throw new \Exception('Gagal menyimpan gambar ke storage');
                }
                if ($anggota->paraf && Storage::disk('public')->exists($anggota->paraf)) {
                    Storage::disk('public')->delete($anggota->paraf);
                }
                $anggota->paraf = $imageName;
                $anggota->save();

                return redirect()->route('admin.bem.paraf.index')->with('success', 'Paraf ketua berhasil diperbarui');
            } else {
                throw new \Exception('Format data signature tidak valid');
            }
        } catch (\Exception $e) {
            Log::error('Error saving signature', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.bem.paraf.index')->with('error', 'Gagal menyimpan paraf: ' . $e->getMessage());
        }
    }
}
