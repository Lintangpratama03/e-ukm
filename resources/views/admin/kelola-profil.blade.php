@extends('layouts.main')
@section('title', 'Kelola Profil')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                        <li class="breadcrumb-item active">Kelola Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button id="btn-tambah" class="btn btn-success mb-2">Tambah Profil</button>
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Nama UKM</th>
                                <th>Visi</th>
                                <th>Misi</th>
                                <th>Deskripsi</th>
                                <th>Kontak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div id="modal-form" class="modal fade">
        <div class="modal-dialog">
            <form id="form-profil" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label>Nama UKM</label>
                        <input type="text" class="form-control" id="nama_ukm" required>
                    </div>
                    <div class="mb-3">
                        <label>Kontak</label>
                        <input type="text" class="form-control" id="kontak">
                    </div>
                    <div class="mb-3">
                        <label>Logo</label>
                        <input type="file" class="form-control" id="logo">
                    </div>
                    <div class="mb-3">
                        <label>Visi</label>
                        <textarea class="form-control" id="visi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Misi</label>
                        <textarea class="form-control" id="misi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="deskripsi"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                ajax: "{{ route('admin.profil.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'logo',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'visi'
                    },
                    {
                        data: 'misi'
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'kontak'
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ]

            });

            $('#btn-tambah').click(function() {
                $('#form-profil')[0].reset();
                $('#id').val('');
                $('#modal-form').modal('show');
            });

            $('#datatable').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/profil/edit') }}/" + id, function(res) {
                    $('#id').val(res.id);
                    $('#nama_ukm').val(res.nama_ukm);
                    $('#kontak').val(res.kontak);
                    $('#modal-form').modal('show');
                });
            });

            $('#form-profil').submit(function(e) {
                e.preventDefault();
                var id = $('#id').val();
                var url = id ? "{{ url('admin/profil/update') }}/" + id :
                    "{{ route('admin.profil.store') }}";

                var formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('nama', $('#nama_ukm').val());
                formData.append('visi', $('#visi').val());
                formData.append('misi', $('#misi').val());
                formData.append('deskripsi', $('#deskripsi').val());
                formData.append('kontak', $('#kontak').val());
                if ($('#logo')[0].files[0]) {
                    formData.append('logo', $('#logo')[0].files[0]);
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        alert(res.message);
                    }
                });
            });

            $('#datatable').on('click', '.delete', function() {
                if (confirm('Yakin hapus profil ini?')) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: "{{ url('admin/profil/delete') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(res) {
                            table.ajax.reload();
                            alert(res.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
