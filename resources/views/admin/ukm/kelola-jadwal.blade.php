@extends('layouts.main')
@section('title', 'Pengajuan Jadwal')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Pengajuan Jadwal</h5>
                <button class="btn btn-success" id="btn-add">+ Jadwal</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table-jadwal" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Waktu</th>
                                <th>Tempat</th>
                                <th>Status Pengajuan</th>
                                <th>Status TTD</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Tambah/Edit --}}
    <div class="modal fade" id="modal-jadwal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-jadwal">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tempat_id" class="form-label">Tempat</label>
                            <select class="form-control select2" id="tempat_id" name="tempat_id[]" multiple="multiple"
                                required data-placeholder="Pilih lokasi kegiatan">
                                @foreach ($tempat as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama_tempat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            // Initialize Select2 with custom styling
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Pilih lokasi kegiatan",
                allowClear: true,
                closeOnSelect: false,
                templateResult: formatState,
                dropdownParent: $('#modal-jadwal')
            });

            // Custom formatting for Select2 options
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                return $('<span><i class="fas fa-map-marker-alt me-2"></i> ' + state.text + '</span>');
            }

            let table = $('#table-jadwal').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('user.jadwal.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_kegiatan'
                    },
                    {
                        data: 'waktu'
                    },
                    {
                        data: 'tempat'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'status_ttd',
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    targets: [5, 6],
                    className: 'text-center'
                }]
            });

            // Fix modal closing issues - using Bootstrap 5 syntax
            $('#btn-add').click(function() {
                $('#form-jadwal')[0].reset();
                $('#tempat_id').val(null).trigger('change');
                $('#modal-jadwal').modal('show');
            });

            // Ensure modal can be closed with close button and backdrop click
            $('#modal-jadwal').on('hidden.bs.modal', function() {
                $('#form-jadwal')[0].reset();
                $('#tempat_id').val(null).trigger('change');
            });

            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get("{{ url('admin/jadwal') }}/" + id + "/edit", function(data) {
                    $('#nama_kegiatan').val(data.nama_kegiatan);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_selesai').val(data.tanggal_selesai);
                    $('#tempat_id').val(data.tempat.map(t => t.id)).trigger('change');
                    $('#modal-jadwal').modal('show');
                });
            });

            $('#form-jadwal').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.post("{{ route('user.jadwal.store') }}", formData, function(response) {
                    $('#modal-jadwal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses!', response.message, 'success');
                }).fail(function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON.message, 'error');
                });
            });

            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "user/jadwal/" + id,
                            type: "DELETE",
                            success: function(response) {
                                Swal.fire("Terhapus!", "Data berhasil dihapus.",
                                    "success");
                                table.ajax.reload();
                            },
                            error: function() {
                                Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom styling for Select2 */
        .select2-container--bootstrap4 .select2-selection {
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            height: auto;
            min-height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.25rem;
            font-size: 0.875rem;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            background-color: #3E79F7;
            border: none;
            color: white;
            border-radius: 20px;
            padding: 2px 10px;
            margin-top: 2px;
            margin-right: 5px;
            font-size: 0.875rem;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
            font-weight: bold;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #f8f9fa;
            background: none;
        }

        .select2-dropdown {
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: 1px solid #dee2e6;
        }

        .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
            background-color: #3E79F7;
        }

        .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
        }

        .select2-container--bootstrap4 .select2-results__option {
            padding: 0.375rem 0.75rem;
        }
    </style>
@endsection
