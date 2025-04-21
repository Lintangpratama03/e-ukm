@extends('layouts.main')
@section('title', 'Dashboard UKM')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Summary Cards with consistent styling -->
        <div class="row mb-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Kegiatan Yang Diajukan Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-3">
                                    <div class="bg-primary rounded-circle p-3 mb-2">
                                        <i class="fas fa-clipboard-list fa-2x text-white"></i>
                                    </div>
                                    <h6 class="text-primary fw-bold mb-1">KEGIATAN YANG DIAJUKAN</h6>
                                    <h2 class="fw-bold mb-0">{{ $totalKegiatan }}</h2>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="bg-primary w-100" style="height: 6px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan Divalidasi Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-3">
                                    <div class="bg-success rounded-circle p-3 mb-2">
                                        <i class="fas fa-check-circle fa-2x text-white"></i>
                                    </div>
                                    <h6 class="text-success fw-bold mb-1">KEGIATAN DIVALIDASI</h6>
                                    <h2 class="fw-bold mb-0">{{ $kegiatanValidasi }}</h2>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="bg-success w-100" style="height: 6px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan Bulan Ini Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-3">
                                    <div class="bg-info rounded-circle p-3 mb-2">
                                        <i class="fas fa-calendar-week fa-2x text-white"></i>
                                    </div>
                                    <h6 class="text-info fw-bold mb-1">KEGIATAN BULAN INI</h6>
                                    <h2 class="fw-bold mb-0">{{ $kegiatanBulanIni }}</h2>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="bg-info w-100" style="height: 6px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan Tahun Ini Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-3">
                                    <div class="bg-warning rounded-circle p-3 mb-2">
                                        <i class="fas fa-chart-bar fa-2x text-white"></i>
                                    </div>
                                    <h6 class="text-warning fw-bold mb-1">KEGIATAN TAHUN INI</h6>
                                    <h2 class="fw-bold mb-0">{{ $kegiatanTahunIni }}</h2>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="bg-warning w-100" style="height: 6px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Monthly Activity Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow rounded-3">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Aktivitas Bulanan {{ date('Y') }}</h6>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active"
                                id="viewTotal">Semua</button>
                            <button type="button" class="btn btn-sm btn-outline-success"
                                id="viewValidated">Divalidasi</button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="viewPending">Menunggu</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="monthlyActivityChart" style="max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                /* Upcoming Events Carousel Styling */
                .upcoming-events-wrapper {
                    position: relative;
                }

                .upcoming-events-carousel {
                    scroll-behavior: smooth;
                    -webkit-overflow-scrolling: touch;
                    scrollbar-width: none;
                    /* For Firefox */
                }

                .upcoming-events-carousel::-webkit-scrollbar {
                    display: none;
                    /* For Chrome, Safari, and Opera */
                }

                .event-card {
                    transition: transform 0.3s ease;
                }

                .nav-buttons .btn {
                    padding: 0.25rem 0.5rem;
                }

                .dot {
                    transition: background-color 0.3s ease;
                }

                .dot.active {
                    background-color: #4e73df;
                }

                /* Optional: Add hover effect to event cards */
                .event-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
                }
            </style>
            <!-- Upcoming Activities Card -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow rounded-3">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Kegiatan Mendatang</h6>
                        <div class="nav-buttons">
                            <button class="btn btn-sm btn-outline-primary scroll-left">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary scroll-right">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="upcoming-events-wrapper position-relative">
                            <div class="upcoming-events-carousel d-flex flex-nowrap overflow-hidden">
                                @forelse($upcomingKegiatan as $kegiatan)
                                    @php
                                        $daysRemaining = \Carbon\Carbon::now()->diffInDays(
                                            \Carbon\Carbon::parse($kegiatan->tanggal_mulai),
                                        );
                                        $badgeClass =
                                            $daysRemaining <= 7
                                                ? 'bg-danger'
                                                : ($daysRemaining <= 14
                                                    ? 'bg-warning'
                                                    : 'bg-info');
                                    @endphp
                                    <div class="event-card flex-shrink-0" style="width: 100%;">
                                        <div class="p-3 border-bottom position-relative">
                                            <div class="badge {{ $badgeClass }} text-white px-2 position-absolute"
                                                style="top: 0.5rem; right: 0.5rem;">
                                                {{ $daysRemaining }} hari lagi
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="event-date text-center me-3 bg-light rounded p-2">
                                                    <div class="month fw-bold text-uppercase small">
                                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('M') }}
                                                    </div>
                                                    <div class="day fs-4 fw-bold">
                                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d') }}
                                                    </div>
                                                </div>
                                                <div class="event-details ms-2">
                                                    <h6 class="mb-1 fw-bold">{{ $kegiatan->nama_kegiatan }}</h6>
                                                    <div class="small text-muted">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        {{ $kegiatan->tempats->pluck('nama_tempat')->join(', ') ?: 'Tidak ada tempat terdaftar' }}
                                                    </div>
                                                    <div class="mt-1">
                                                        @if ($kegiatan->status_validasi === 'divalidasi')
                                                            <span class="badge bg-success">Disetujui</span>
                                                        @elseif($kegiatan->status_validasi === 'ditolak')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @else
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center w-100">
                                        <i class="fas fa-calendar-xmark fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">Tidak ada kegiatan mendatang.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        @if (count($upcomingKegiatan) > 0)
                            <div class="event-indicators text-center py-2">
                                @for ($i = 0; $i < count($upcomingKegiatan); $i++)
                                    <span class="dot mx-1" data-index="{{ $i }}"></span>
                                @endfor
                            </div>

                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow mb-4 rounded-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Kegiatan Terbaru</h6>
                <a href="{{ route('user.jadwal.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list me-1"></i> Semua Kegiatan
                </a>
            </div>
            <div class="card-body">
                <!-- Filter controls -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filterYear" class="small fw-bold">Tahun</label>
                            <select class="form-select form-select-sm" id="filterYear">
                                <option value="">Semua Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $years = range($currentYear, $currentYear - 5);
                                @endphp
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filterMonth" class="small fw-bold">Bulan</label>
                            <select class="form-select form-select-sm" id="filterMonth">
                                <option value="">Semua Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filterStatus" class="small fw-bold">Status</label>
                            <select class="form-select form-select-sm" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="divalidasi">Divalidasi</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="resetFilters" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="recentActivitiesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            var recentTable = $('#recentActivitiesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.dashboard.getData') }}",
                    data: function(d) {
                        d.year = $('#filterYear').val();
                        d.month = $('#filterMonth').val();
                        d.status = $('#filterStatus').val();
                    }
                },
                columns: [{
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'tempat',
                        name: 'tempat'
                    },
                    {
                        data: 'status',
                        name: 'status_validasi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ]
            });

            $('#filterYear, #filterMonth, #filterStatus').change(function() {
                recentTable.ajax.reload();
            });

            $('#resetFilters').click(function() {
                $('#filterYear, #filterMonth, #filterStatus').val('');
                recentTable.ajax.reload();
            });

            const monthlyData = @json($monthlyActivity);

            const labels = monthlyData.map(item => item.month);
            const totalData = monthlyData.map(item => item.total);
            const validatedData = monthlyData.map(item => item.validated);
            const pendingData = monthlyData.map(item => item.pending);

            const ctx = document.getElementById('monthlyActivityChart').getContext('2d');
            const activityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Kegiatan',
                        data: totalData,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Divalidasi',
                        data: validatedData,
                        backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1,
                        hidden: true
                    }, {
                        label: 'Menunggu',
                        data: pendingData,
                        backgroundColor: 'rgba(255, 193, 7, 0.8)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1,
                        hidden: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const datasetLabel = context.dataset.label || '';
                                    return `${datasetLabel}: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });

            // Toggle between chart views
            $('#viewTotal').click(function() {
                activityChart.data.datasets[0].hidden = false;
                activityChart.data.datasets[1].hidden = true;
                activityChart.data.datasets[2].hidden = true;
                $(this).addClass('active').siblings().removeClass('active');
                activityChart.update();
            });

            $('#viewValidated').click(function() {
                activityChart.data.datasets[0].hidden = true;
                activityChart.data.datasets[1].hidden = false;
                activityChart.data.datasets[2].hidden = true;
                $(this).addClass('active').siblings().removeClass('active');
                activityChart.update();
            });

            $('#viewPending').click(function() {
                activityChart.data.datasets[0].hidden = true;
                activityChart.data.datasets[1].hidden = true;
                activityChart.data.datasets[2].hidden = false;
                $(this).addClass('active').siblings().removeClass('active');
                activityChart.update();
            });
            let currentEventIndex = 0;
            const totalEvents = $('.event-card').length;

            // Set the first dot as active if events exist
            if (totalEvents > 0) {
                $('.dot[data-index="0"]').addClass('active');
            }

            // Style the dots
            $('.dot').css({
                'display': 'inline-block',
                'width': '10px',
                'height': '10px',
                'border-radius': '50%',
                'background-color': '#ccc',
                'cursor': 'pointer'
            });

            $('.dot.active').css('background-color', '#4e73df');

            // Add click event to indicator dots
            $('.dot').click(function() {
                const index = $(this).data('index');
                showEvent(index);
            });

            // Add click events to navigation buttons
            $('.scroll-left').click(function() {
                if (currentEventIndex > 0) {
                    showEvent(currentEventIndex - 1);
                } else {
                    // Loop to the last event
                    showEvent(totalEvents - 1);
                }
            });

            $('.scroll-right').click(function() {
                if (currentEventIndex < totalEvents - 1) {
                    showEvent(currentEventIndex + 1);
                } else {
                    // Loop to the first event
                    showEvent(0);
                }
            });

            // Function to show event at specific index
            function showEvent(index) {
                if (index >= 0 && index < totalEvents) {
                    currentEventIndex = index;

                    // Update dot indicators
                    $('.dot').css('background-color', '#ccc').removeClass('active');
                    $(`.dot[data-index="${index}"]`).css('background-color', '#4e73df').addClass('active');

                    // Scroll to the selected event
                    $('.upcoming-events-carousel').animate({
                        scrollLeft: $('.event-card').outerWidth() * index
                    }, 300);
                }
            }

            // Add keyboard support for navigation
            $(document).keydown(function(e) {
                if ($('.upcoming-events-carousel:hover').length > 0) {
                    if (e.keyCode === 37) { // Left arrow
                        $('.scroll-left').click();
                    } else if (e.keyCode === 39) { // Right arrow
                        $('.scroll-right').click();
                    }
                }
            });
        });
    </script>
@endsection
