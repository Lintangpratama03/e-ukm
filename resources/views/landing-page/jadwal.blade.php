@extends('layouts.landing-page.main')
@php
    $headerTitle = 'Jadwal Kegiatan UKM';
    $headerDescription = 'Informasi dan statistik kegiatan unit kegiatan mahasiswa';
@endphp
<style>
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }

    .card-header {
        background-color: rgba(248, 249, 250, 0.5);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.2rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Chart Container Improvements */
    .chart {
        margin: 0.5rem 0;
        position: relative;
        border-radius: 10px;
        padding: 10px;
        transition: all 0.3s ease;
    }

    /* Better Typography */
    h2.text-gradient.text-primary {
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    h5.mb-0 {
        font-weight: 600;
        color: #444;
    }

    /* Styled Tables */
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background-color: rgba(248, 249, 250, 0.8);
        font-weight: 600;
        color: #444;
        border-top: none;
        padding: 12px 15px;
    }

    .table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(245, 247, 250, 0.7);
    }

    /* Button Styling */
    .btn {
        font-weight: 500;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }

    .btn-sm {
        padding: 0.3rem 0.7rem;
        font-size: 0.85rem;
    }

    .btn-primary {
        background-image: linear-gradient(to right, #4285f4, #5292f7);
        border: none;
    }

    .btn-primary:hover {
        background-image: linear-gradient(to right, #3b78e7, #4285f4);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(66, 133, 244, 0.3);
    }

    .btn-outline-primary {
        border-color: #4285f4;
        color: #4285f4;
    }

    .btn-outline-primary:hover {
        background-color: #4285f4;
        color: white;
    }

    .btn-info {
        background-image: linear-gradient(to right, #0dcaf0, #3dd5f3);
        border: none;
        color: white;
    }

    .btn-info:hover {
        background-image: linear-gradient(to right, #0ab2d2, #0dcaf0);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(13, 202, 240, 0.3);
    }

    /* Badge Styling */
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
        border-radius: 4px;
    }

    .bg-primary {
        background-image: linear-gradient(to right, #4285f4, #5292f7);
    }

    .bg-success {
        background-image: linear-gradient(to right, #34a853, #46b565);
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background-image: linear-gradient(to right, #4285f4, #5292f7);
        border-bottom: none;
        border-radius: 12px 12px 0 0;
        padding: 1.5rem;
    }

    .modal-header .modal-title {
        font-weight: 600;
        color: white;
    }

    .modal-body {
        padding: 1.8rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card {
            margin-bottom: 20px;
        }

        .chart {
            min-height: 250px;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .row:nth-child(2) .card {
        animation-delay: 0.1s;
    }

    .row:nth-child(3) .card {
        animation-delay: 0.2s;
    }
</style>
@section('content')
    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">
        <section class="pt-3 pb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h2 class="text-center text-gradient text-primary"></h2>
                        <p class="text-center"></p>
                    </div>
                </div>

                <!-- Baris pertama: Grafik -->
                <div class="row mb-5">
                    <!-- Grafik Batang: Total Kegiatan per Bulan -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header p-3">
                                <h5 class="mb-0">Total Kegiatan per Bulan</h5>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-bar-kegiatan" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Pie: Jumlah Kegiatan per UKM -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header p-3">
                                <h5 class="mb-0">Distribusi Kegiatan per UKM</h5>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-pie-ukm" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Baris kedua: Dua tabel -->
                <div class="row">
                    <!-- Tabel 1: Semua Jadwal Kegiatan dengan Filter -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Daftar Jadwal Kegiatan</h5>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-secondary filter-btn active"
                                            data-filter="semua">Semua</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary filter-btn"
                                            data-filter="mendatang">Mendatang</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary filter-btn"
                                            data-filter="terlaksana">Terlaksana</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tabelSemuaKegiatan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>UKM</th>
                                                <th>Tanggal</th>
                                                <th>Tempat</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jadwal as $index => $kegiatan)
                                                @php
                                                    $status = \Carbon\Carbon::parse(
                                                        $kegiatan->tanggal_mulai,
                                                    )->isFuture()
                                                        ? 'mendatang'
                                                        : 'terlaksana';
                                                @endphp
                                                <tr data-status="{{ $status }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                                                    <td>{{ $kegiatan->ukm->nama }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $kegiatan->tempats->pluck('nama_tempat')->implode(', ') }}</td>
                                                    <td>
                                                        @if ($status == 'mendatang')
                                                            <span class="badge bg-primary">Mendatang</span>
                                                        @else
                                                            <span class="badge bg-success">Terlaksana</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-secondary btn-sm"
                                                            onclick="showEventDetail(
                                                            '{{ $kegiatan->nama_kegiatan }}',
                                                            '{{ $kegiatan->ukm->nama }}',
                                                            '{{ $kegiatan->tempats->pluck('nama_tempat')->implode(', ') }}',
                                                            '{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}',
                                                            '{{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}',
                                                            '{{ $kegiatan->deskripsi }}'
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

                    <!-- Tabel 2: UKM Teraktif -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header p-3">
                                <h5 class="mb-0">UKM Teraktif</h5>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tabelUkmAktif">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama UKM</th>
                                                <th>Jumlah Kegiatan</th>
                                                <th>Kegiatan Terakhir</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ukmAktif as $index => $ukm)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $ukm->nama }}</td>
                                                    <td>{{ $ukm->jumlah_kegiatan }}</td>
                                                    <td>{{ $ukm->kegiatan_terakhir ? \Carbon\Carbon::parse($ukm->kegiatan_terakhir)->format('d M Y') : '-' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('home.profil-ukm', $ukm->user_id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
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
                    <h4 id="modalTitle" class="text-info"></h4>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dataTableOptions = {
                responsive: true,
                language: {
                    search: "Cari:",
                    paginate: {
                        first: "<<",
                        last: ">>",
                        next: ">",
                        previous: "<"
                    }
                },
                drawCallback: function() {
                    $('.dataTables_paginate .pagination').removeClass('pagination-primary').addClass(
                        'pagination-secondary');
                }
            };

            // Inisialisasi DataTables dengan konfigurasi
            var tabelKegiatan = $('#tabelSemuaKegiatan').DataTable({
                ...dataTableOptions,
                pageLength: 10
            });

            var tabelUkmAktif = $('#tabelUkmAktif').DataTable({
                ...dataTableOptions,
                pageLength: 5
            });


            // Fungsi filter tabel kegiatan
            $('.filter-btn').on('click', function() {
                $('.filter-btn').removeClass('active').addClass('btn-outline-secondary').removeClass(
                    'btn-secondary');
                $(this).addClass('active').removeClass('btn-outline-secondary').addClass('btn-secondary');

                var filter = $(this).data('filter');

                if (filter === 'semua') {
                    tabelKegiatan.columns(5).search('').draw();
                } else {
                    tabelKegiatan.columns(5).search(filter).draw();
                }
            });

            // Data untuk grafik batang
            var ctx1 = document.getElementById('chart-bar-kegiatan').getContext('2d');

            // Improved gradient for bar chart
            var gradientFill = ctx1.createLinearGradient(0, 0, 0, 300);
            gradientFill.addColorStop(0, 'rgba(66, 133, 244, 0.9)');
            gradientFill.addColorStop(1, 'rgba(66, 133, 244, 0.4)');

            var shadowColor = 'rgba(0, 0, 0, 0.07)';

            // Custom tooltip with nicer formatting
            const customTooltip = {
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                titleColor: '#333',
                bodyColor: '#666',
                bodyFont: {
                    family: 'Arial',
                    size: 13
                },
                titleFont: {
                    family: 'Arial',
                    size: 15,
                    weight: 'bold'
                },
                padding: 12,
                borderColor: 'rgba(0, 0, 0, 0.1)',
                borderWidth: 1,
                boxShadow: '0px 3px 8px rgba(0, 0, 0, 0.15)',
                cornerRadius: 6,
                displayColors: false,
                callbacks: {
                    title: function(context) {
                        return context[0].label;
                    },
                    label: function(context) {
                        return 'Jumlah Kegiatan: ' + context.raw + ' kegiatan';
                    }
                }
            };

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bulan) !!},
                    datasets: [{
                        label: 'Jumlah Kegiatan',
                        tension: 0.3,
                        borderWidth: 0,
                        borderRadius: 6,
                        borderSkipped: false,
                        backgroundColor: gradientFill,
                        data: {!! json_encode($jumlahKegiatanPerBulan) !!},
                        maxBarThickness: 35,
                        shadow: {
                            color: shadowColor,
                            blur: 10,
                            offsetX: 0,
                            offsetY: 4
                        }
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: customTooltip,
                        title: {
                            display: true,
                            text: 'Distribusi Kegiatan Sepanjang Tahun',
                            font: {
                                family: 'Arial',
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            },
                            color: '#333'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)',
                                lineWidth: 1
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: 'Arial',
                                    size: 12
                                },
                                color: '#666',
                                padding: 10,
                                callback: function(value) {
                                    return value + ' kegiatan';
                                }
                            },
                            border: {
                                dash: [4, 4]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Arial',
                                    size: 12
                                },
                                color: '#666',
                                padding: 10
                            }
                        }
                    },
                },
            });

            // Data untuk grafik pie dengan warna yang lebih elegan
            var ctx2 = document.getElementById('chart-pie-ukm').getContext('2d');

            // Elegant color palette for pie chart
            const elegantColors = [
                'rgba(76, 175, 80, 0.8)', // Green
                'rgba(33, 150, 243, 0.8)', // Blue
                'rgba(255, 152, 0, 0.8)', // Orange
                'rgba(156, 39, 176, 0.8)', // Purple
                'rgba(3, 169, 244, 0.8)', // Light Blue
                'rgba(233, 30, 99, 0.8)', // Pink
                'rgba(0, 188, 212, 0.8)', // Cyan
                'rgba(205, 220, 57, 0.8)', // Lime
                'rgba(121, 85, 72, 0.8)', // Brown
                'rgba(96, 125, 139, 0.8)' // Blue Grey
            ];

            const elegantBorderColors = [
                'rgba(76, 175, 80, 1)', // Green
                'rgba(33, 150, 243, 1)', // Blue
                'rgba(255, 152, 0, 1)', // Orange
                'rgba(156, 39, 176, 1)', // Purple
                'rgba(3, 169, 244, 1)', // Light Blue
                'rgba(233, 30, 99, 1)', // Pink
                'rgba(0, 188, 212, 1)', // Cyan
                'rgba(205, 220, 57, 1)', // Lime
                'rgba(121, 85, 72, 1)', // Brown
                'rgba(96, 125, 139, 1)' // Blue Grey
            ];

            new Chart(ctx2, {
                type: 'doughnut', // Changed from pie to doughnut for more modern look
                data: {
                    labels: {!! json_encode($namaUkm) !!},
                    datasets: [{
                        data: {!! json_encode($jumlahKegiatanUkm) !!},
                        backgroundColor: elegantColors,
                        borderColor: elegantBorderColors,
                        borderWidth: 2,
                        hoverOffset: 10,
                        spacing: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%', // Creates donut hole
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Arial',
                                    size: 12
                                },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#333',
                            bodyColor: '#666',
                            bodyFont: {
                                family: 'Arial',
                                size: 13
                            },
                            titleFont: {
                                family: 'Arial',
                                size: 15,
                                weight: 'bold'
                            },
                            padding: 12,
                            borderColor: 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 6,
                            displayColors: true,
                            boxPadding: 3,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((acc, val) => acc + val,
                                        0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} kegiatan (${percentage}%)`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Persentase Kontribusi Kegiatan per UKM',
                            font: {
                                family: 'Arial',
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            },
                            color: '#333'
                        },
                        // Add subtle shadow
                        shadowPlugin: {
                            shadowOffsetX: 3,
                            shadowOffsetY: 3,
                            shadowBlur: 10,
                            shadowColor: 'rgba(0, 0, 0, 0.2)',
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });

            // Adds subtle hover effect for both charts
            const chartContainers = document.querySelectorAll('.chart');
            chartContainers.forEach(container => {
                container.style.transition = 'all 0.3s ease';
                container.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02)';
                    this.style.boxShadow = '0 8px 30px rgba(0, 0, 0, 0.12)';
                });
                container.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.boxShadow = 'none';
                });
            });
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
