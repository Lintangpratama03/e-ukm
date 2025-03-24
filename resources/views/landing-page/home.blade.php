@extends('layouts.landing-page.main')

@section('content')
    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">
        <section class="pt-3 pb-4" id="count-stats">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 mx-auto py-3">
                        <div class="row">
                            <div class="col-md-4 position-relative">
                                <div class="p-3 text-center">
                                    <h1 class="text-gradient text-dark">
                                        <span id="state1" countTo="{{ $kegiatanHariIni }}">0</span>
                                    </h1>
                                    <h5 class="mt-3">Kegiatan Hari Ini</h5>
                                    <p class="text-sm font-weight-normal">
                                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                    <hr class="vertical dark">
                                </div>
                            </div>

                            <div class="col-md-4 position-relative">
                                <div class="p-3 text-center">
                                    <h1 class="text-gradient text-dark">
                                        <span id="state2" countTo="{{ $kegiatanBulanIni }}">0</span>
                                    </h1>
                                    <h5 class="mt-3">Kegiatan Bulan Ini</h5>
                                    <p class="text-sm font-weight-normal">
                                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}
                                    </p>
                                    <hr class="vertical dark">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-3 text-center">
                                    <h1 class="text-gradient text-dark">
                                        <span id="state3" countTo="{{ $kegiatanTahunIni }}">0</span>
                                    </h1>
                                    <h5 class="mt-3">Kegiatan Tahun Ini</h5>
                                    <p class="text-sm font-weight-normal">
                                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="my-5 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Kalender Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Daftar Kegiatan Yang Akan Datang</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="eventsTable" class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Kegiatan</th>
                                                <th>UKM</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($events as $index => $event)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $event->nama_kegiatan }}</td>
                                                    <td>{{ $event->ukm->nama }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm"
                                                            onclick="showEventDetail(
                                                            '{{ $event->nama_kegiatan }}',
                                                            '{{ $event->ukm->nama }}',
                                                            '{{ $event->tempats->pluck('nama_tempat')->implode(', ') }}',
                                                            '{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}',
                                                            '{{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}',
                                                            '{{ $event->deskripsi }}'
                                                        )">
                                                            Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pb-5 position-relative bg-gradient-dark mx-n3">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 text-start mb-5 mt-5">
                        <h3 class="text-white z-index-1 position-relative">Unit Kegiatan Mahasiswa</h3>
                        <p class="text-white opacity-8 mb-0">Berbagai kegiatan mahasiswa untuk mengembangkan minat dan bakat
                        </p>
                    </div>
                </div>

                <div class="row">
                    @foreach ($ukmProfiles->chunk(2) as $chunk)
                        @foreach ($chunk as $profile)
                            <div class="col-lg-6 col-12">
                                <div class="card card-profile mt-4">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mt-n5">
                                            <a href="javascript:;">
                                                <div class="p-3 pe-md-0">
                                                    @if ($profile->logo)
                                                        <img class="w-100 border-radius-md shadow-lg"
                                                            src="{{ asset('storage/' . $profile->logo) }}"
                                                            alt="{{ $profile->nama }}">
                                                    @else
                                                        <img class="w-100 border-radius-md shadow-lg"
                                                            src="{{ asset('assets/images/logopolinema.png') }}"
                                                            alt="default image">
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-8 col-md-6 col-12 my-auto">
                                            <div class="card-body ps-lg-0">
                                                <h5 class="mb-0">{{ $profile->nama }}</h5>
                                                <h6 class="text-info">UKM</h6>
                                                <p class="mb-0">{{ Str::limit($profile->deskripsi, 100) }}</p>
                                                <a href="javascript:;"
                                                    class="text-info text-sm icon-move-right">Selengkapnya
                                                    <i class="fas fa-arrow-right text-xs ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Detail Kegiatan -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="eventModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modalTitle" class="text-secondary"></h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>UKM:</strong> <span id="modalUKM"></span></p>
                            <p><strong>Tempat:</strong> <span id="modalTempat"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> <span id="modalDate"></span></p>
                        </div>
                    </div>
                    <hr>
                    <p id="modalDescription"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#eventsTable').DataTable({
                responsive: true,
                pageLength: 5,
                drawCallback: function() {
                    $('.dataTables_paginate .pagination').removeClass('pagination-primary').addClass(
                        'pagination-secondary');
                }
            });


            function startCountUp(elementId) {
                let element = document.getElementById(elementId);
                if (element) {
                    let countTo = parseInt(element.getAttribute("countTo")) || 0;
                    const countUp = new CountUp(elementId, countTo);
                    if (!countUp.error) {
                        countUp.start();
                    } else {
                        console.error(countUp.error);
                    }
                }
            }

            startCountUp('state1');
            startCountUp('state2');
            startCountUp('state3');

            // Initialize FullCalendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route('events') }}',
                eventClick: function(info) {
                    // Extract data from event object
                    var eventData = info.event.extendedProps;

                    // Call showEventDetail with the same parameters that the table uses
                    showEventDetail(
                        info.event.title,
                        eventData.ukm,
                        eventData.tempat,
                        eventData.tanggalMulai,
                        eventData.tanggalSelesai,
                        eventData.deskripsi
                    );
                },
                height: 'auto',
                themeSystem: 'bootstrap5'
            });
            calendar.render();
        });

        function showEventDetail(nama, ukm, tempat, tanggalMulai, tanggalSelesai, deskripsi) {
            document.getElementById('modalTitle').innerText = nama;
            document.getElementById('modalUKM').innerText = ukm;
            document.getElementById('modalTempat').innerText = tempat;
            document.getElementById('modalDate').innerText = tanggalMulai + " - " + tanggalSelesai;
            document.getElementById('modalDescription').innerText = deskripsi;

            // Use Bootstrap Modal to show the modal
            var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
            myModal.show();
        }
    </script>
@endsection
