@extends('layouts.main')
@section('title', 'Kelola Profil')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">

            {{-- Sidebar Kiri (Ganti Password & Foto Profil) --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        {{-- Foto Profil --}}
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $profil->logo) }}" alt="Foto Profil"
                                class="img-thumbnail rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>

                        {{-- Nama Profil --}}
                        <h4 class="fw-bold mb-3">{{ old('nama', $profil->nama) }}</h4>

                        {{-- Form Ganti Password --}}
                        <form action="{{ route('profile.updatePassword') }}" method="POST">
                            @csrf

                            {{-- Password Lama --}}
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password_lama" placeholder="Password Lama"
                                    required>
                            </div>

                            {{-- Password Baru --}}
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password_baru" placeholder="Password Baru"
                                    required>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password_konfirmasi"
                                    placeholder="Konfirmasi Password" required>
                            </div>

                            {{-- Tombol Simpan Password --}}
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Form Update Profil (Main Content) --}}
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Update Profil</h5>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Organisasi</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('nama', $profil->nama) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Visi</label>
                                <textarea class="form-control" name="visi" rows="2">{{ old('visi', $profil->visi) }}</textarea>
                            </div>

                            {{-- Misi --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Misi</label>
                                <textarea class="form-control" name="misi" rows="2">{{ old('misi', $profil->misi) }}</textarea>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                            </div>

                            {{-- Kontak --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kontak</label>
                                <input type="text" class="form-control" name="kontak"
                                    value="{{ old('kontak', $profil->kontak) }}">
                            </div>

                            {{-- Upload Logo --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Logo</label>
                                <input type="file" class="form-control" name="logo" accept="image/*">
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
