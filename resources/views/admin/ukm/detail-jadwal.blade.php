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
                            @if ($jadwal->lembar_pengesahan)
                                <a href="{{ asset('storage/' . $jadwal->lembar_pengesahan) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="dripicons-preview"></i> Lihat Lembar Pengesahan
                                </a>
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if ($jadwal->status_validasi == 'divalidasi')
                    <form action="{{ route('user.jadwal.upload', $jadwal->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload Lembar Pengesahan</label>
                                    <input type="file" name="lembar_pengesahan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload Proposal</label>
                                    <input type="file" name="proposal" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
