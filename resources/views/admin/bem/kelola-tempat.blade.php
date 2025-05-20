@extends('layouts.main')
@section('title', 'Kelola Tempat')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Kelola Tempat</h5>
                <button class="btn btn-success" id="btnTambah">+ Tempat</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tempatTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tempat</th>
                            <th>Foto</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalTempat">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formTempat">
                    @csrf
                    <input type="hidden" id="tempat_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tempat</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Tempat</label>
                            <input type="text" class="form-control" id="nama_tempat" name="nama_tempat" required>
                        </div>
                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            <img id="previewFoto" src="" class="img-thumbnail mt-2" width="100">
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#tempatTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tempat.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_tempat'
                    },
                    {
                        data: 'foto',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#btnTambah').click(function() {
                $('#modalTempat').modal('show');
                $('#formTempat')[0].reset();
                $('#tempat_id').val('');
                $('#previewFoto').attr('src', '').hide();
            });


            // **Simpan Data (Tambah / Edit)**
            $('#formTempat').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#tempat_id').val();
                var url = id ? "{{ url('admin/tempat/update') }}/" + id :
                    "{{ route('admin.tempat.store') }}";
                var method = id ? "POST" : "POST";

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#modalTempat').modal('hide');
                        table.ajax.reload();
                    }
                });
            });

            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/tempat/edit') }}/" + id, function(data) {
                    $('#modalTempat').modal('show');
                    $('.modal-title').text('Edit Tempat');
                    $('#modalTempat').modal('show');
                    $('#tempat_id').val(data.id);
                    $('#nama_tempat').val(data.nama_tempat);
                    $('#deskripsi').val(data.deskripsi);
                    if (data.foto) {
                        $('#previewFoto').attr('src', "{{ asset('storage') }}/" + data.foto).show();
                    } else {
                        $('#previewFoto').hide();
                    }
                });
            });

            // Hapus Anggota
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('admin/tempat/delete') }}/" + id,
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
