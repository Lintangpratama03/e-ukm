@extends('layouts.main')
@section('title', 'Kelola Anggota')
@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Kelola Anggota</h5>
                <button class="btn btn-success" id="btnTambah"> + Anggota</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="anggotaTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Jabatan</th>
                            <th>No HP</th>
                            <th>Jurusan</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalAnggota">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formAnggota">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Anggota</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" class="form-control" name="anggota_id" id="anggota_id">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jabatan</label>
                                <select class="form-control" id="jabatan" name="jabatan">
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil Ketua">Wakil Ketua</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Bendahara">Bendahara</option>
                                    <option value="Kepala Bidang">Kepala Bidang</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Bidang</label>
                                <input type="text" class="form-control" id="bidang" name="bidang">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>No HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jurusan</label>
                                <select class="form-control" id="jurusan" name="jurusan">
                                    <option value="MI">MI</option>
                                    <option value="TM">TM</option>
                                    <option value="TMPP">TMPP</option>
                                    <option value="AKT">AKT</option>
                                    <option value="KEU">KEU</option>
                                    <option value="ELEKTRO">ELEKTRO</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                                <img id="previewFoto" src="" class="img-thumbnail mt-2" width="100">
                            </div>
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
            var table = $('#anggotaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('anggota.get') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'nim'
                    },
                    {
                        data: 'jabatan'
                    },
                    {
                        data: 'no_hp'
                    },
                    {
                        data: 'jurusan'
                    },
                    {
                        data: 'kelas'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Tambah Anggota
            $('#btnTambah').click(function() {
                $('#modalAnggota').modal('show');
                $('#formAnggota')[0].reset();
                $('#anggota_id').val('');
                $('#previewFoto').attr('src', ''); // Reset foto
                $('.modal-title').text('Tambah Anggota');
            });

            // Simpan atau Update Anggota
            $('#formAnggota').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var url = $('#anggota_id').val() == '' ? "{{ route('anggota.store') }}" :
                    "{{ route('anggota.update') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#modalAnggota').modal('hide');
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
            });

            // Edit Anggota
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('anggota/edit') }}/" + id, function(data) {
                    $('#modalAnggota').modal('show');
                    $('.modal-title').text('Edit Anggota');
                    $('#anggota_id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#nim').val(data.nim);
                    $('#jabatan').val(data.jabatan);
                    $('#bidang').val(data.bidang);
                    $('#no_hp').val(data.no_hp);
                    $('#jurusan').val(data.jurusan);
                    $('#kelas').val(data.kelas);
                    if (data.foto) {
                        $('#previewFoto').attr('src', '/storage/' + data.foto);
                    } else {
                        $('#previewFoto').attr('src', '');
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
                            url: "{{ url('anggota/delete') }}/" + id,
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
