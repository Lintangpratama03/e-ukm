@extends('layouts.landing-page.main')
@php
    $headerTitle = 'PROFIL ORGANISASI';
    $headerDescription = '';
@endphp
<style>
    /* Styling for Calendar */
    .calendar-container {
        height: 500px;
        width: 100%;
    }

    /* Styling for Documentation Images */
    .dokumentasi-container {
        overflow: hidden;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .dokumentasi-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .dokumentasi-container:hover .dokumentasi-img {
        transform: scale(1.05);
    }

    /* Card Styling */
    /* .card {
        transition: box-shadow 0.3s ease, transform 0.2s ease;
        border-radius: 10px;
        overflow: hidden;
    } */

    .card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    /* Tab Styling */
    .nav-tabs .nav-link {
        font-weight: 500;
        color: #344767;
        border: 0;
        border-bottom: 2px solid transparent;
        padding: 0.5rem 1rem;
        margin-right: 1rem;
        transition: all 0.2s ease;
    }

    .nav-tabs .nav-link.active {
        color: #1A73E8;
        border-bottom: 2px solid #1A73E8;
        background-color: transparent;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    /* Avatar Styling */
    .avatar-container {
        display: inline-block;
        border: 2px solid white;
        border-radius: 50%;
        overflow: hidden;
    }

    .avatar-lg {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }

    /* DataTable Styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #1A73E8 !important;
        border-color: #1A73E8 !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #4A90E2 !important;
        border-color: #4A90E2 !important;
        color: white !important;
    }
</style>
@section('content')
    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6 mb-4">
        <section class="py-sm-7 py-5 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto">
                        <div class="mt-n8 mt-md-n9 text-center">
                            @if ($ukm->logo)
                                <img class="avatar avatar-xxl shadow-xl position-relative z-index-2"
                                    src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama }}" loading="lazy">
                            @else
                                <img class="avatar avatar-xxl shadow-xl position-relative z-index-2"
                                    src="{{ asset('assets/images/logopolinema.png') }}" alt="default" loading="lazy">
                            @endif
                        </div>
                        <div class="row py-5">
                            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h3 class="mb-0">{{ $ukm->nama }}</h3>
                                </div>
                                <p class="text-lg mb-0">
                                    {{ $ukm->deskripsi ?? '-' }}
                                </p>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h4>Visi</h4>
                                        <p>{{ $ukm->visi ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Misi</h4>
                                        <p>{{ $ukm->misi ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="row mt-5">
                            <div class="col-12">
                                <ul class="nav nav-tabs justify-content-center" id="ukmTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="jadwal-tab" data-bs-toggle="tab"
                                            data-bs-target="#jadwal" type="button" role="tab" aria-controls="jadwal"
                                            aria-selected="true">
                                            Jadwal Kegiatan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="anggota-tab" data-bs-toggle="tab"
                                            data-bs-target="#anggota" type="button" role="tab" aria-controls="anggota"
                                            aria-selected="false">
                                            Anggota UKM
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="dokumentasi-tab" data-bs-toggle="tab"
                                            data-bs-target="#dokumentasi" type="button" role="tab"
                                            aria-controls="dokumentasi" aria-selected="false">
                                            Dokumentasi
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content mt-4" id="ukmTabContent">
                                    <!-- Tab 1: Jadwal Kegiatan -->
                                    <div class="tab-pane fade show active" id="jadwal" role="tabpanel"
                                        aria-labelledby="jadwal-tab">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div id="calendar" class="calendar-container"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Daftar Jadwal Kegiatan</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table align-items-center mb-0" id="jadwalTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Kegiatan</th>
                                                                        <th>Tanggal Mulai</th>
                                                                        <th>Tanggal Selesai</th>
                                                                        <th>Tempat</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($ukm->jadwal && $ukm->jadwal->count() > 0)
                                                                        @foreach ($ukm->jadwal as $jadwal)
                                                                            <tr>
                                                                                <td>{{ $jadwal->nama_kegiatan }}</td>
                                                                                <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}
                                                                                </td>
                                                                                <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
                                                                                </td>
                                                                                <td>{{ $jadwal->tempats->pluck('nama_tempat')->implode(', ') }}
                                                                                </td>
                                                                                <td>
                                                                                    <span
                                                                                        class="badge bg-{{ $jadwal->status_validasi == 'divalidasi' ? 'success' : 'warning' }}">
                                                                                        {{ ucfirst($jadwal->status_validasi) }}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="5" class="text-center">Belum ada
                                                                                jadwal kegiatan.</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 2: Anggota UKM -->
                                    <div class="tab-pane fade" id="anggota" role="tabpanel" aria-labelledby="anggota-tab">
                                        <div class="row">
                                            @php
                                                $anggotaList = App\Models\Anggota::where(
                                                    'user_id',
                                                    $ukm->user_id,
                                                )->get();
                                            @endphp

                                            @if ($anggotaList && $anggotaList->count() > 0)
                                                @foreach ($anggotaList as $anggota)
                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                        <div class="card h-100">
                                                            <div
                                                                class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 text-center">
                                                                <div
                                                                    class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                                                    <div class="avatar-container mb-2">
                                                                        @if ($anggota->foto)
                                                                            <img src="{{ asset('storage/' . $anggota->foto) }}"
                                                                                class="avatar rounded-circle avatar-lg"
                                                                                alt="{{ $anggota->nama }}">
                                                                        @else
                                                                            <img src="{{ asset('assets/img/default-avatar.png') }}"
                                                                                class="avatar rounded-circle avatar-lg"
                                                                                alt="default">
                                                                        @endif
                                                                    </div>
                                                                    <h5 class="text-white m-0">{{ $anggota->nama }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="card-body pt-3">
                                                                <div class="text-center">
                                                                    <h6 class="mb-0 text-primary">{{ $anggota->jabatan }}
                                                                    </h6>
                                                                    <p class="mb-0 text-sm">{{ $anggota->nim }}</p>
                                                                </div>
                                                                <hr>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item border-0 ps-0 pt-0">
                                                                        <strong>Jurusan:</strong> {{ $anggota->jurusan }}
                                                                    </li>
                                                                    <li class="list-group-item border-0 ps-0">
                                                                        <strong>Kelas:</strong> {{ $anggota->kelas }}
                                                                    </li>
                                                                    <li class="list-group-item border-0 ps-0">
                                                                        <strong>No HP:</strong> {{ $anggota->no_hp }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12 text-center">
                                                    <p>Belum ada data anggota UKM.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Tab 3: Dokumentasi -->
                                    <div class="tab-pane fade" id="dokumentasi" role="tabpanel"
                                        aria-labelledby="dokumentasi-tab">
                                        <div class="row">
                                            @if ($ukm->jadwal && $ukm->jadwal->count() > 0)
                                                @php $hasDocumentation = false; @endphp

                                                @foreach ($ukm->jadwal as $jadwal)
                                                    @if ($jadwal->dokumentasi && $jadwal->dokumentasi->count() > 0)
                                                        @php $hasDocumentation = true; @endphp

                                                        <div class="col-12 mb-4">
                                                            <h4 class="text-center mb-3">{{ $jadwal->nama_kegiatan }}</h4>
                                                            <div class="row">
                                                                @foreach ($jadwal->dokumentasi as $dokumentasi)
                                                                    <div class="col-lg-4 col-md-6 mb-4">
                                                                        <div class="card h-100">
                                                                            <div class="dokumentasi-container">
                                                                                <img src="{{ asset('storage/dokumentasi/' . $dokumentasi->foto) }}"
                                                                                    class="card-img-top dokumentasi-img"
                                                                                    alt="Dokumentasi {{ $jadwal->nama_kegiatan }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#imageModal{{ $dokumentasi->id }}">
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <p class="card-text">
                                                                                    {{ $dokumentasi->deskripsi ?: 'Tidak ada deskripsi' }}
                                                                                </p>
                                                                                <p class="card-text text-muted">
                                                                                    <small>{{ \Carbon\Carbon::parse($dokumentasi->created_at)->format('d M Y') }}</small>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                                @if (!$hasDocumentation)
                                                    <div class="col-12 text-center">
                                                        <p>Belum ada dokumentasi kegiatan.</p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-12 text-center">
                                                    <p>Belum ada kegiatan yang terdokumentasi.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Image Modals -->
    @foreach ($ukm->jadwal as $jadwal)
        @if ($jadwal->dokumentasi && $jadwal->dokumentasi->count() > 0)
            @foreach ($jadwal->dokumentasi as $dokumentasi)
                <div class="modal fade" id="imageModal{{ $dokumentasi->id }}" tabindex="-1"
                    aria-labelledby="imageModalLabel{{ $dokumentasi->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $dokumentasi->id }}">
                                    {{ $jadwal->nama_kegiatan }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/dokumentasi/' . $dokumentasi->foto) }}" class="img-fluid"
                                    alt="Dokumentasi {{ $jadwal->nama_kegiatan }}">
                                <p class="mt-3">
                                    {{ $dokumentasi->deskripsi ?: 'Tidak ada deskripsi' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 id="event-title" class="mb-2"></h6>
                    <p><strong>UKM:</strong> <span id="event-ukm"></span></p>
                    <p><strong>Tempat:</strong> <span id="event-tempat"></span></p>
                    <p><strong>Tanggal Mulai:</strong> <span id="event-start"></span></p>
                    <p><strong>Tanggal Selesai:</strong> <span id="event-end"></span></p>
                    <p><strong>Deskripsi:</strong></p>
                    <p id="event-description"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.10.25/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize FullCalendar
            var calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    locale: 'id',
                    events: "{{ route('home.getUkmEvents', ['id' => $ukm->user_id]) }}",
                    eventClick: function(info) {
                        $('#event-title').text(info.event.title);
                        $('#event-ukm').text(info.event.extendedProps.ukm);
                        $('#event-tempat').text(info.event.extendedProps.tempat);
                        $('#event-start').text(info.event.extendedProps.tanggalMulai);
                        $('#event-end').text(info.event.extendedProps.tanggalSelesai);
                        $('#event-description').text(info.event.extendedProps.deskripsi ||
                            'Tidak ada deskripsi');
                        $('#eventModal').modal('show');
                    }
                });
                calendar.render();
            }

            // Initialize DataTable
            $('#jadwalTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                responsive: true,
                order: [
                    [1, 'desc']
                ]
            });

            // Tab switching - reinitialize FullCalendar when tab is shown
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                if (e.target.id === 'jadwal-tab' && calendar) {
                    calendar.updateSize();
                }
            });
        });
    </script>
@endsection
