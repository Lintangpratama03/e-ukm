@extends('layouts.main')
@section('title', 'Kelola Paraf')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Update Paraf Ketua</h5>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if ($ketua)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6>Informasi Ketua</h6>
                                    <table class="table">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $ketua->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <td>{{ $ketua->nim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jurusan</th>
                                            <td>{{ $ketua->jurusan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kelas</th>
                                            <td>{{ $ketua->kelas }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Data Paraf Ketua</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if ($ketua->paraf)
                                                        <div class="text-center mb-3">
                                                            <h6>Paraf Saat Ini</h6>
                                                            <img src="{{ asset('storage/' . $ketua->paraf) }}"
                                                                alt="Paraf Ketua" class="img-fluid border"
                                                                style="max-height: 150px;">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <form id="signature-form" action="{{ route('admin.bem.paraf.store') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="anggota_id" value="{{ $ketua->id }}">
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Tanda Tangan</label>
                                                            <div class="border rounded p-3 bg-light">
                                                                <canvas id="signature-pad" class="signature-pad w-100"
                                                                    height="200"></canvas>
                                                            </div>
                                                            <input type="hidden" name="signature" id="signature-data">
                                                        </div>

                                                        <style>
                                                            #signature-pad {
                                                                border: 2px dashed #6c757d;
                                                                /* Border abu-abu dengan gaya dashed */
                                                                border-radius: 8px;
                                                                /* Sudut lebih halus */
                                                                background-color: #fff;
                                                                /* Warna latar belakang tetap putih */
                                                                cursor: crosshair;
                                                                /* Menunjukkan bahwa area bisa digambar */
                                                            }
                                                        </style>

                                                        <div class="form-group d-flex justify-content-between">
                                                            <button type="button" id="clear-signature"
                                                                class="btn btn-secondary">Hapus Paraf</button>
                                                            <button type="button" id="save-signature"
                                                                class="btn btn-primary">Simpan Paraf</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                Tidak ada anggota dengan jabatan Ketua. Silahkan tambahkan terlebih dahulu.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signature-pad');
            let signaturePad;

            if (canvas) {
                signaturePad = new SignaturePad(canvas, {
                    penColor: 'rgb(0, 0, 0)',
                    minWidth: 1,
                    maxWidth: 3
                });

                function resizeCanvas() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                    signaturePad.clear();
                }

                window.onload = resizeCanvas;
                window.addEventListener("resize", resizeCanvas);

                document.getElementById('clear-signature').addEventListener('click', function() {
                    signaturePad.clear();
                });

                document.getElementById('save-signature').addEventListener('click', function() {
                    if (signaturePad.isEmpty()) {
                        alert('Harap buat tanda tangan terlebih dahulu!');
                        return false;
                    }

                    try {
                        const signatureData = canvas.toDataURL(
                        'image/png'); // Pastikan format PNG transparan
                        document.getElementById('signature-data').value = signatureData;
                        document.getElementById('signature-form').submit();
                    } catch (error) {
                        console.error("Error capturing signature:", error);
                        alert('Terjadi kesalahan saat menyimpan tanda tangan. Silakan coba lagi.');
                    }
                });
            }
        });
    </script>
@endsection
