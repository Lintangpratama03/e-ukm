@extends('layouts.main')
@section('title', 'Detail Jadwal')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header">
                <h5>Detail Jadwal</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('user.jadwal.index') }}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
                <table class="table">
                    <tr>
                        <th>Nama Kegiatan</th>
                        <td>{{ $jadwal->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td>{{ date('d-m-Y', strtotime($jadwal->tanggal_mulai)) }} sampai
                            {{ date('d-m-Y', strtotime($jadwal->tanggal_selesai)) }}</td>
                    </tr>
                    <tr>
                        <th>Tempat</th>
                        <td>{{ $jadwal->tempats->pluck('nama_tempat')->implode(', ') }}</td>
                    </tr>
                    <tr>
                        <th>Status Pengajuan</th>
                        <td><span
                                class="badge bg-{{ $jadwal->status_validasi == 'divalidasi' ? 'success' : 'warning' }}">{{ ucfirst($jadwal->status_validasi) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status TTD</th>
                        <td><span
                                class="badge bg-{{ $jadwal->status_ttd == 'berhasil' ? 'success' : 'secondary' }}">{{ ucfirst($jadwal->status_ttd) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Proposal</th>
                        <td>
                            @if ($jadwal->proposal)
                                <a href="{{ asset('storage/' . $jadwal->proposal) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="dripicons-preview"></i> Lihat Proposal
                                </a>
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Lembar Pengesahan</th>
                        <td>
                            <div class="text-center mt-3 mb-3">
                                <a href="{{ route('user.jadwal.generate-pdf', $jadwal->id) }}" class="btn btn-primary">
                                    <i class="mdi mdi-file-pdf"></i> Simpan Lembar Pengesahan sebagai PDF
                                </a>
                            </div>
                            @if ($jadwal->status_ttd == 'berhasil')
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if ($jadwal->status_validasi == 'divalidasi')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Data Lembar Pengesahan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Form Upload Proposal -->
                                <form action="{{ route('user.jadwal.upload', $jadwal->id) }}" method="POST"
                                    enctype="multipart/form-data" class="w-100">
                                    @csrf
                                    <div class="row">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Kegiatan</label>
                                                <input type="text" name="nama_kegiatan" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Ketua Pelaksana</label>
                                                <input type="text" name="ketua_pelaksana" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nim Ketua Pelaksana</label>
                                                <input type="text" name="nim_ketua_pelaksana" class="form-control"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sasaran</label>
                                                <input type="text" name="sasaran" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Program</label>
                                                <textarea name="program" class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Indikator Kerja</label>
                                                <textarea name="indikator_kerja" class="form-control" required></textarea>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Volume (Peserta)</label>
                                                <input type="text" name="volume" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Pelaksanaan</label>
                                                <input type="date" name="tanggal_pelaksanaan" class="form-control"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah Dana (Rp)</label>
                                                <input type="text" name="jumlah_dana" class="form-control rupiah"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sumber Dana</label>
                                                <input type="text" name="sumber_dana" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen Pembimbing Kemahasiswaan</label>
                                                <select name="dpk" class="form-control select2" required>
                                                    <option value="">Pilih DPK</option>
                                                    <option value="dony">Dosen 1</option>
                                                    <option value="ratna">Dosen 2</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Proposal</label>
                                                <input type="file" name="proposal" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih DPK",
                allowClear: true
            });

            $('.rupiah').on('keyup', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(formatRupiah(value));
            });

            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>
@endsection
