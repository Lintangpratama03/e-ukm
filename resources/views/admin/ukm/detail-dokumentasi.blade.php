@extends('layouts.main')
@section('title', 'Detail Dokumentasi Kegiatan')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        </script>
    @endif

    <div class="container mt-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">Detail Dokumentasi Kegiatan</h5>
                <a href="{{ route('dokumentasi.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Nama Kegiatan</th>
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
                        </table>
                    </div>
                </div>

                @if ($role == 'user')
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Upload Dokumentasi</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dokumentasi.upload', $jadwal->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="foto">Foto Kegiatan <span class="text-danger">*</span></label>
                                            <input type="file" name="foto" id="foto"
                                                class="form-control @error('foto') is-invalid @enderror" accept="image/*"
                                                required>
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi Foto</label>
                                            <input type="text" name="deskripsi" id="deskripsi"
                                                class="form-control @error('deskripsi') is-invalid @enderror"
                                                placeholder="Masukkan deskripsi foto (opsional)">
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload mr-1"></i> Upload Foto
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
                <!-- Tabel Dokumentasi -->
                <div class="card">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Foto Kegiatan</h6>
                    </div>
                    <div class="card-body">
                        @if ($jadwal->dokumentasi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Tanggal Upload</th>
                                            <th width="30%">Foto</th>
                                            <th>Deskripsi</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwal->dokumentasi as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset('storage/dokumentasi/' . $item->foto) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/dokumentasi/' . $item->foto) }}"
                                                            alt="Foto Kegiatan" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    </a>
                                                </td>
                                                <td>{{ $item->deskripsi ?: '-' }}</td>
                                                <td>
                                                    <form action="{{ route('dokumentasi.destroy', $item->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-1"></i> Belum ada foto yang diunggah untuk kegiatan ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                }
            });
        });
    </script>
@endsection
