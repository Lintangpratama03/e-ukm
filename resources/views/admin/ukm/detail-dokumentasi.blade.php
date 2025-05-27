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
                            <tr>
                                <th>Total Foto</th>
                                <td>
                                    <span class="badge badge-warning">Pending:
                                        {{ $jadwal->dokumentasi->where('status', 0)->count() }}</span>
                                    <span class="badge badge-success ml-2">Validated:
                                        {{ $jadwal->dokumentasi->where('status', 1)->count() }}</span>
                                </td>
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
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle"></i> Foto yang diupload akan menunggu validasi dari admin
                                </small>
                            </form>
                        </div>
                    </div>
                @endif

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
                                            <th width="25%">Foto</th>
                                            <th>Deskripsi</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Aksi</th>
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
                                                    @if ($item->status == 0)
                                                        <span>
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span>
                                                            Validasi
                                                        </span>
                                                        @if ($item->validated_at)
                                                            <br><small
                                                                class="text-muted">{{ $item->validated_at }}</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role == 'admin')
                                                        @if ($item->status == 0)
                                                            <button type="button"
                                                                class="btn btn-sm btn-success validate-foto"
                                                                data-id="{{ $item->id }}" title="Validasi Foto">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-warning reject-foto"
                                                                data-id="{{ $item->id }}" title="Tolak Foto">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                        <button type="button" class="btn btn-sm btn-danger delete-foto"
                                                            data-id="{{ $item->id }}" title="Hapus Foto">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    @else
                                                        @if ($item->user_id == Auth::id() && $item->status == 0)
                                                            <button type="button" class="btn btn-sm btn-danger delete-foto"
                                                                data-id="{{ $item->id }}" title="Hapus Foto">
                                                                <i class="dripicons-trash"></i>
                                                            </button>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    @endif


                                                    <form id="validate-form-{{ $item->id }}"
                                                        action="{{ route('dokumentasi.validate', $item->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>

                                                    <form id="reject-form-{{ $item->id }}"
                                                        action="{{ route('dokumentasi.reject', $item->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('dokumentasi.destroy', $item->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
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

            // Validate foto
            $('.validate-foto').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Validasi',
                    text: "Apakah Anda yakin ingin memvalidasi foto ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Validasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('validate-form-' + id).submit();
                    }
                });
            });

            // Reject foto
            $('.reject-foto').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Tolak',
                    text: "Apakah Anda yakin ingin menolak dan menghapus foto ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('reject-form-' + id).submit();
                    }
                });
            });

            // Delete foto
            $('.delete-foto').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus foto ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endsection
