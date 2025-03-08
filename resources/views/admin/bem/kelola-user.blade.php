@extends('layouts.main')
@section('title', 'Kelola User UKM')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Kelola User UKM</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="userTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user"></i> Detail User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="detail_logo" class="img-thumbnail" width="150" height="150">
                        </div>
                        <div class="col-md-8">
                            <p><strong>Email:</strong> <span id="detail_email"></span></p>
                            <p><strong>Username:</strong> <span id="detail_username"></span></p>
                            <p><strong>Role:</strong> <span id="detail_role"></span></p>
                            <p><strong>Nama:</strong> <span id="detail_nama"></span></p>
                            <p><strong>Kontak:</strong> <span id="detail_kontak"></span></p>
                        </div>
                    </div>
                    <hr>
                    <h6><i class="fas fa-bullseye"></i> Visi</h6>
                    <p id="detail_visi"></p>
                    <h6><i class="fas fa-bullhorn"></i> Misi</h6>
                    <p id="detail_misi"></p>
                    <h6><i class="fas fa-file-alt"></i> Deskripsi</h6>
                    <p id="detail_deskripsi"></p>
                </div>
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
            var table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Detail User
            $(document).on('click', '.btn-detail', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/user/detail') }}/" + id, function(data) {
                    $('#detail_email').text(data.email);
                    $('#detail_username').text(data.username);
                    $('#detail_role').text(data.role);
                    $('#detail_nama').text(data.profil ? data.profil.nama : '-');
                    $('#detail_kontak').text(data.profil ? data.profil.kontak : '-');
                    $('#detail_visi').text(data.profil ? data.profil.visi : '-');
                    $('#detail_misi').text(data.profil ? data.profil.misi : '-');
                    $('#detail_deskripsi').text(data.profil ? data.profil.deskripsi : '-');
                    $('#detail_logo').attr('src', data.profil && data.profil.logo ? '/storage/' +
                        data.profil.logo : '/images/default.png');
                    $('#modalDetail').modal('show');
                });
            });

            // Aktifkan User
            $(document).on('click', '.btn-activate', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Aktifkan user ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, aktifkan!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/user/activate') }}/" + id,
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire("Berhasil", response.message, "success");
                            }
                        });
                    }
                });
            });

            // Hapus User
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Hapus user ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('admin/user/delete') }}/" + id,
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire("Berhasil", response.message, "success");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
