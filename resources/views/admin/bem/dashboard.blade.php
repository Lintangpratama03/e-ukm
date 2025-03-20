@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <!-- All cards in a container with consistent spacing -->
            <div class="container-fluid">
                <div class="row">
                    <!-- Kegiatan Yang Diajukan Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-2">
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-2">
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-2">
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
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-white shadow-sm h-100 rounded-3 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-center text-center py-2">
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
            <div class="col-lg-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Partisipasi UKM Dalam Kegiatan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="ukmActivityChart" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kegiatan</h6>
                    </div>
                    <div class="card-body">
                        <p>Dashboard ini menampilkan informasi partisipasi UKM dalam kegiatan. Grafik menunjukkan jumlah
                            kegiatan yang diikuti oleh masing-masing UKM, diurutkan dari yang terbanyak hingga yang paling
                            sedikit.</p>
                        <p>Untuk melihat detail kegiatan dari masing-masing UKM, klik tombol "Lihat Detail" pada tabel di
                            bawah.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Kegiatan UKM</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="ukmDataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama UKM</th>
                                <th>Jumlah Kegiatan</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="activityDetailsModal" tabindex="-1" aria-labelledby="activityDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="activityDetailsModalLabel">Detail Kegiatan UKM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="activityDetailsTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Tempat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Define formatDate function
            function formatDate(dateString) {
                if (!dateString) return 'N/A';
                return dateString;
            }

            // Load UKM activity data for chart
            $.ajax({
                url: "{{ route('admin.ukm-activity-data') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    renderUkmChart(data);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            // Initialize main UKM data table
            var table = $('#ukmDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.ukm-datatable') }}",
                columns: [{
                        data: 'ukm_name',
                        name: 'ukm_name'
                    },
                    {
                        data: 'total_activities',
                        name: 'total_activities'
                    },
                    {
                        data: 'ukm_details',
                        name: 'ukm_details',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
            $('#ukmDataTable').on('click', '.view-details', function() {
                const id = $(this).data('id');
                const ukmName = $(this).closest('tr').find('td:first').text();
                $.ajax({
                    url: "{{ route('admin.ukm-kegiatan-detail') }}",
                    method: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $('#activityDetailsTable tbody').empty();
                        if (response.data && Array.isArray(response.data)) {
                            response.data.forEach(activity => {
                                let statusBadge = '';
                                switch (activity.status_validasi) {
                                    case 'divalidasi':
                                        statusBadge =
                                            '<span class="badge bg-success">Disetujui</span>';
                                        break;
                                    case 'ditolak':
                                        statusBadge =
                                            '<span class="badge bg-danger">Ditolak</span>';
                                        break;
                                    case 'menunggu':
                                        statusBadge =
                                            '<span class="badge bg-warning">Proses</span>';
                                        break;
                                    default:
                                        statusBadge =
                                            '<span class="badge bg-secondary">Unknown</span>';
                                }

                                $('#activityDetailsTable tbody').append(`
                                <tr>
                                    <td>${activity.nama_kegiatan}</td>
                                    <td>${activity.tanggal || 'N/A'}</td>
                                    <td>${activity.tempat || 'N/A'}</td>
                                    <td>${statusBadge}</td>
                                </tr>
                                `);
                            });
                        } else {
                            console.log("Invalid response format:", response);
                            $('#activityDetailsTable tbody').append(`
                            <tr>
                                <td colspan="4">No data available</td>
                            </tr>
                            `);
                        }
                        $('#activityDetailsModalLabel').text(`Kegiatan ${ukmName}`);
                        $('#activityDetailsModal').modal('show');
                    },
                    error: function(error) {
                        console.error("Error fetching activity details:", error);
                        $('#activityDetailsTable tbody').append(`
                            <tr>
                                <td colspan="4">Error loading data</td>
                            </tr>
                            `);
                        $('#activityDetailsModalLabel').text(`Kegiatan ${ukmName}`);
                        $('#activityDetailsModal').modal('show');
                    }
                });
            });

            function renderUkmChart(data) {
                const ctx = document.getElementById('ukmActivityChart').getContext('2d');
                const chartData = data.slice(0, 10);

                const ukmChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.map(item => item.ukm_name),
                        datasets: [{
                            label: 'Jumlah Kegiatan',
                            data: chartData.map(item => item.total_activities),
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Jumlah Kegiatan: ${context.raw}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
