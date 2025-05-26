<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal LKMM-TD</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
            color: #333;
            background: #fff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            /* border-bottom: 3px solid #000102; */
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            color: #000000;
        }

        .header h2 {
            font-size: 16px;
            margin: 10px 0;
            color: #000000;
        }

        .author-info {
            text-align: center;
            margin: 30px 0;
            font-size: 14px;
        }

        .institution {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            color: #000000;
        }

        .year {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
        }

        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 8px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .section {
            margin: 30px 0;
            page-break-inside: avoid;
        }

        .section h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 15px 0;
            color: #000000;
            border-bottom: 2px solid #000000;
            padding-bottom: 5px;
        }

        .section h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0 10px 0;
            color: #000000;
        }

        .section p {
            text-align: justify;
            margin: 10px 0;
        }

        .schedule-table,
        .budget-table,
        .committee-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 12px;
        }

        .schedule-table th,
        .schedule-table td,
        .budget-table th,
        .budget-table td,
        .committee-table th,
        .committee-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        .schedule-table th,
        .budget-table th,
        .committee-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .budget-table td:last-child {
            text-align: right;
        }

        .list-item {
            margin: 5px 0;
        }

        .program-list {
            margin: 10px 0;
        }

        .agenda-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 12px;
        }

        .agenda-table th,
        .agenda-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        .agenda-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .methods ol {
            padding-left: 20px;
        }

        .methods li {
            margin: 8px 0;
            text-align: justify;
        }

        @media print {
            body {
                margin: 0;
                padding: 20px;
            }

            .container {
                box-shadow: none;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Proposal Kegiatan</h1>
            <h1>{{ $proposal->kegiatan_singkat }}</h1>
            <h2>"{{ $proposal->kegiatan_lengkap }}"</h2>
        </div>

        <!-- Author Info -->
        <div class="author-info">
            <p><strong>Oleh :</strong></p>
            <p>{{ $proposal->nama_penyusun }}</p>
            <p>NIM. {{ $proposal->nim_penyusun }}</p>
        </div>
        <div>
            <center><img src="{{ $logo }}" alt="Paraf Ketua" width="300"></center>
        </div>
        <br>
        <!-- Institution -->
        <div class="institution">
            <p>{{ $proposal->nama_institusi }}</p>
            <p>PSDKU POLINEMA KOTA KEDIRI</p>
        </div>

        <!-- Year -->
        <div class="year">
            {{ $proposal->tahun }}
        </div>

        <!-- I. LATAR BELAKANG -->
        <div class="section">
            <h2>I. LATAR BELAKANG</h2>

            <h3>1.1 Dasar Kegiatan</h3>
            <p>Dasar kegiatan pelaksanaan kegiatan ini adalah:</p>
            @foreach ($proposal->dasar_kegiatan as $dasar)
                <div class="list-item">{{ $loop->iteration }}. {{ $dasar }}</div>
            @endforeach

            <h3>1.2 Gambaran Umum</h3>
            <p>{{ $proposal->gambaran_umum }}</p>
        </div>

        <!-- II. PENERIMA MANFAAT -->
        <div class="section">
            <h2>II. PENERIMA MANFAAT</h2>
            <p>{{ $proposal->penerima_manfaat }}</p>
        </div>

        <!-- III. STRATEGI PENCAPAIAN KELUARAN -->
        <div class="section">
            <h2>III. STRATEGI PENCAPAIAN KELUARAN</h2>

            <h3>3.1 Metode Pelaksanaan</h3>
            <div class="methods">
                <ol type="a">
                    @foreach ($proposal->metode_pelaksanaan as $metode)
                        <li>{{ $metode }}</li>
                    @endforeach
                </ol>
            </div>

            <h3>3.2 Tahapan dan Waktu Pelaksanaan</h3>

            <h4>a. Tahapan Pelaksanaan</h4>
            <p>Pelaksanaan kegiatan ini dilakukan dengan tahapan sebagai berikut:</p>
            @foreach ($proposal->tahapan_pelaksanaan as $tahapan)
                <div class="list-item">{{ $loop->iteration }}. {{ $tahapan }}</div>
            @endforeach

            <h4>b. Waktu Pelaksanaan</h4>
            <p>{{ $proposal->deskripsi_waktu_pelaksanaan }}</p>

            <!-- Tambahan daftar tempat -->

            <table class="schedule-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Bulan</th>
                        @foreach ($proposal->bulan_headers as $bulan)
                            <th colspan="4">{{ $bulan }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($proposal->bulan_headers as $bulan)
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->jadwal_kegiatan as $kegiatan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align: left;">{{ $kegiatan['nama'] }}</td>
                            @foreach ($kegiatan['timeline'] as $minggu)
                                <td>{{ $minggu ? 'v' : '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>c. Tempat Pelaksanaan:</strong></p>
            @if ($jadwal->tempats && $jadwal->tempats->count() > 0)
                @foreach ($jadwal->tempats as $tempat)
                    <div class="list-item">{{ $loop->iteration }}. {{ $tempat->nama_tempat }}</div>
                @endforeach
            @else
                <div class="list-item">Tempat pelaksanaan akan ditentukan kemudian</div>
            @endif
            <h4>d. Kurun Waktu Pencapaian Keluaran</h4>
            <p>{{ $proposal->kurun_waktu_pencapaian }}</p>

            <h4>e. Materi Kegiatan</h4>
            <p>{{ $proposal->deskripsi_materi_kegiatan }}</p>
            @foreach ($proposal->materi_kegiatan as $materi)
                <div class="list-item">
                    <strong>{{ $materi['nama'] }}</strong> : {{ $materi['judul'] }}<br>
                    <strong>Pemateri</strong> : {{ $materi['pemateri'] }}
                </div>
            @endforeach

            <h4>f. Susunan Acara</h4>
            <p><strong>{{ $proposal->hari_tanggal_acara }}</strong></p>

            <table class="agenda-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                        <th>Pengisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->susunan_acara as $acara)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $acara['waktu'] }}</td>
                            <td>{{ $acara['kegiatan'] }}</td>
                            <td>{{ $acara['pengisi'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- IV. BIAYA YANG DIPERLUKAN -->
        <div class="section">
            <h2>IV. BIAYA YANG DIPERLUKAN</h2>
            <p>{{ $proposal->deskripsi_biaya }}</p>

            <h3>Lampiran 1. Anggaran Belanja</h3>
            <p style="text-align: center; font-weight: bold;">Rencana Anggaran Belanja</p>
            <p style="text-align: center; font-weight: bold;">{{ $proposal->judul_anggaran }}</p>

            <table class="budget-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Akun</th>
                        <th>Kategori</th>
                        <th>Uraian</th>
                        <th>Rincian</th>
                        <th>Total</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->anggaran_belanja as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['akun'] }}</td>
                            <td>{{ $item['kategori'] }}</td>
                            <td>{{ $item['uraian'] }}</td>
                            <td>{{ $item['rincian'] }}</td>
                            <td>{{ $item['total_barang'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ $item['harga_satuan_format'] }}</td>
                            <td>{{ $item['total_harga_format'] }}</td>
                        </tr>
                    @endforeach
                    <tr style="font-weight: bold; background-color: #f5f5f5;">
                        <td colspan="8">TOTAL</td>
                        <td>{{ $proposal->total_anggaran_format }}</td>
                    </tr>
                </tbody>
            </table>

            <h3>Lampiran 2. Susunan Kepanitiaan</h3>
            <p style="text-align: center; font-weight: bold;">Susunan Kepanitiaan</p>
            <p style="text-align: center; font-weight: bold;">{{ $proposal->judul_kepanitiaan }}</p>

            <table class="committee-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->susunan_kepanitiaan as $panitia)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $panitia['nama'] }}</td>
                            <td>{{ $panitia['nim'] }}</td>
                            <td>{{ $panitia['prodi'] }}</td>
                            <td>{{ $panitia['jabatan'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
