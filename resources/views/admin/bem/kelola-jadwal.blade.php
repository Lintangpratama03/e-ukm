@extends('layouts.main')
@section('title', 'Pengajuan Jadwal')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Pengajuan Jadwal</h5>
                <button class="btn btn-success" id="btn-add" style="display: none;">+ Jadwal</button>
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

    <div class="modal fade" id="modal-jadwal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="form-jadwal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                        <div class="form-group">
                            <label>Tempat</label>
                            <select class="form-control select2" id="tempat_id" name="tempat_id[]" multiple="multiple"
                                required>
                                @foreach ($tempat as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama_tempat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
            $('.select2').select2({
                theme: 'bootstrap5'
            });

            let table = $('#table-jadwal').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('admin.jadwal.getData') }}",
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


            $('#btn-add').click(function() {
                $('#form-jadwal')[0].reset();
                $('#tempat_id').val([]).trigger('change');
                $('#modal-jadwal').modal('show');
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
                $.post("{{ route('admin.jadwal.store') }}", formData, function(response) {
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
                            url: "admin/jadwal/" + id,
                            type: "DELETE",
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire("Terhapus!", "Data berhasil dihapus.",
                                    "success");
                                $('#dataTable').DataTable().ajax.reload();
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
@endsection
