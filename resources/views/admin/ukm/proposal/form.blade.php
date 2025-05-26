@extends('layouts.main')
@section('title', 'Form Data Proposal')

@section('content')
    <style>
        .timeline-checkboxes {
            max-height: 80px;
            overflow-y: auto;
        }

        .form-check {
            min-width: 40px;
            text-align: center;
        }

        .form-check-label {
            font-size: 0.8rem;
        }

        #jadwalTable th,
        #jadwalTable td {
            vertical-align: middle;
        }
    </style>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header">
                <h5>Form Data Proposal - {{ $jadwal->nama_kegiatan }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.jadwal.storeProposal', $jadwal->id) }}" method="POST">
                    @csrf

                    <!-- Informasi Dasar -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>Informasi Dasar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Kegiatan Singkat</label>
                                        <input type="text" name="kegiatan_singkat" class="form-control"
                                            value="{{ old('kegiatan_singkat', $proposal->kegiatan_singkat ?? '') }}"
                                            placeholder="LKMM-TD" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Nama Penyusun</label>
                                        <input type="text" name="nama_penyusun" class="form-control"
                                            value="{{ old('nama_penyusun', $proposal->nama_penyusun ?? '') }}"
                                            placeholder="Abyan Syahrul Rifai" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>NIM Penyusun</label>
                                        <input type="text" name="nim_penyusun" class="form-control"
                                            value="{{ old('nim_penyusun', $proposal->nim_penyusun ?? '') }}"
                                            placeholder="2141280005" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Tahun</label>
                                        <input type="number" name="tahun" class="form-control"
                                            value="{{ old('tahun', $proposal->tahun ?? date('Y')) }}" placeholder="2023"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Kegiatan Lengkap</label>
                                        <textarea name="kegiatan_lengkap" class="form-control" rows="3" required
                                            placeholder="LATIHAN KETERAMPILAN MANAJEMEN MAHASISWA TINGKAT DASAR...">{{ old('kegiatan_lengkap', $proposal->kegiatan_lengkap ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Nama Institusi</label>
                                        <textarea name="nama_institusi" class="form-control" rows="2" required
                                            placeholder="BADAN EKSEKUTIF MAHASISWA PSDKU POLITEKNIK NEGERI MALANG...">{{ old('nama_institusi', $proposal->nama_institusi ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Latar Belakang -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>I. Latar Belakang</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Dasar Kegiatan (pisahkan dengan enter)</label>
                                <textarea name="dasar_kegiatan" class="form-control" rows="5" required
                                    placeholder="UUD Negara Republik Indonesia Tahun 1945.&#10;UU No. 20 Tahun 2003 tentang Sistem Pendidikan Nasional.&#10;UU No. 12 Tahun 2012 tentang Pendidikan Tinggi.">{{ old('dasar_kegiatan', $proposal && $proposal->dasar_kegiatan ? (is_array($proposal->dasar_kegiatan) ? implode("\n", $proposal->dasar_kegiatan) : $proposal->dasar_kegiatan) : '') }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label>Gambaran Umum</label>
                                <textarea name="gambaran_umum" class="form-control" rows="4" required
                                    placeholder="Mahasiswa merupakan penerus perjuangan bangsa yang nantinya akan mengemban tampuk pimpinan bangsa...">{{ old('gambaran_umum', $proposal->gambaran_umum ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Penerima Manfaat -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>II. Penerima Manfaat</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Penerima Manfaat</label>
                                <textarea name="penerima_manfaat" class="form-control" rows="3" required
                                    placeholder="Penerima manfaat langsung dari pelaksanaan kegiatan...">{{ old('penerima_manfaat', $proposal->penerima_manfaat ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Strategi Pencapaian -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>III. Strategi Pencapaian Keluaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Metode Pelaksanaan (pisahkan dengan enter)</label>
                                <textarea name="metode_pelaksanaan" class="form-control" rows="4" required
                                    placeholder="Peserta melakukan pendaftaran dengan mengisi gform...&#10;Peserta join grup whatsapp...">{{ old('metode_pelaksanaan', $proposal && $proposal->metode_pelaksanaan ? (is_array($proposal->metode_pelaksanaan) ? implode("\n", $proposal->metode_pelaksanaan) : $proposal->metode_pelaksanaan) : '') }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label>Tahapan Pelaksanaan (pisahkan dengan enter)</label>
                                <textarea name="tahapan_pelaksanaan" class="form-control" rows="4" required
                                    placeholder="Pembentukan panitia kegiatan perancangan kegiatan LKMM-TD.&#10;Pengajuan proposal kegiatan LKMM-TD.">{{ old('tahapan_pelaksanaan', $proposal && $proposal->tahapan_pelaksanaan ? (is_array($proposal->tahapan_pelaksanaan) ? implode("\n", $proposal->tahapan_pelaksanaan) : $proposal->tahapan_pelaksanaan) : '') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Deskripsi Waktu Pelaksanaan</label>
                                        <textarea name="deskripsi_waktu_pelaksanaan" class="form-control" rows="2" required
                                            placeholder="Waktu pelaksanaan kegiatan mengacu pada tahapan pelaksanaan...">{{ old('deskripsi_waktu_pelaksanaan', $proposal->deskripsi_waktu_pelaksanaan ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Kurun Waktu Pencapaian</label>
                                        <textarea name="kurun_waktu_pencapaian" class="form-control" rows="2" required
                                            placeholder="Kegiatan akan dilaksanakan pada tanggal 20 Mei dan 10 Juni 2023...">{{ old('kurun_waktu_pencapaian', $proposal->kurun_waktu_pencapaian ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Deskripsi Materi Kegiatan</label>
                                        <textarea name="deskripsi_materi_kegiatan" class="form-control" rows="2" required
                                            placeholder="Kegiatan terdiri dari pemberian materi secara online:">{{ old('deskripsi_materi_kegiatan', $proposal->deskripsi_materi_kegiatan ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Hari, Tanggal Acara</label>
                                        <input type="text" name="hari_tanggal_acara" class="form-control" required
                                            value="{{ old('hari_tanggal_acara', $proposal->hari_tanggal_acara ?? '') }}"
                                            placeholder="Sabtu, 20 Mei dan 10 Juni 2023">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Materi Kegiatan -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>Materi Kegiatan</h6>
                            <button type="button" class="btn btn-sm btn-primary" id="addMateri">Tambah Materi</button>
                        </div>
                        <div class="card-body">
                            <div id="materiContainer">
                                @if (old('materi_nama') || ($proposal && $proposal->materi_kegiatan))
                                    @php
                                        $materiData = old('materi_nama')
                                            ? array_map(
                                                null,
                                                old('materi_nama'),
                                                old('materi_judul'),
                                                old('materi_pemateri'),
                                            )
                                            : $proposal->materi_kegiatan ?? [];
                                    @endphp
                                    @foreach ($materiData as $index => $materi)
                                        <div class="row mb-2 materi-row">
                                            <div class="col-md-2">
                                                <input type="text" name="materi_nama[]" class="form-control"
                                                    value="{{ is_array($materi) ? $materi['nama'] ?? '' : $materi[0] ?? '' }}"
                                                    placeholder="Materi 1">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="materi_judul[]" class="form-control"
                                                    value="{{ is_array($materi) ? $materi['judul'] ?? '' : $materi[1] ?? '' }}"
                                                    placeholder="Dasar-Dasar Organisasi">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="materi_pemateri[]" class="form-control"
                                                    value="{{ is_array($materi) ? $materi['pemateri'] ?? '' : $materi[2] ?? '' }}"
                                                    placeholder="Ilham Hadi Kurniawan">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removeMateri">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 materi-row">
                                        <div class="col-md-2">
                                            <input type="text" name="materi_nama[]" class="form-control"
                                                placeholder="Materi 1">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="materi_judul[]" class="form-control"
                                                placeholder="Dasar-Dasar Organisasi">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="materi_pemateri[]" class="form-control"
                                                placeholder="Ilham Hadi Kurniawan">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-sm btn-danger removeMateri">Hapus</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>Jadwal Kegiatan</h6>
                        </div>
                        <div class="card-body">
                            <!-- Header Bulan -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label>Header Bulan (pisahkan dengan koma)</label>
                                    <input type="text" name="bulan_headers" class="form-control"
                                        value="{{ old('bulan_headers', $proposal && $proposal->bulan_headers ? (is_array($proposal->bulan_headers) ? implode(', ', $proposal->bulan_headers) : $proposal->bulan_headers) : 'April, Mei, Juni') }}"
                                        placeholder="April, Mei, Juni, Juli" required>
                                    <small class="text-muted">Contoh: April, Mei, Juni</small>
                                </div>
                            </div>

                            <!-- Container untuk Timeline -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="jadwalTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Nama Kegiatan</th>
                                            <th style="width: 60%;">Timeline (Minggu ke-)</th>
                                            <th style="width: 5%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="jadwalContainer">
                                        @if (old('jadwal_nama') || ($proposal && $proposal->jadwal_kegiatan))
                                            @php
                                                $jadwalData = old('jadwal_nama')
                                                    ? array_map(null, old('jadwal_nama'), old('jadwal_timeline'))
                                                    : $proposal->jadwal_kegiatan ?? [];
                                            @endphp
                                            @foreach ($jadwalData as $index => $jadwal)
                                                <tr class="jadwal-row">
                                                    <td>
                                                        <input type="text" name="jadwal_nama[]" class="form-control"
                                                            value="{{ is_array($jadwal) ? $jadwal['nama'] ?? '' : $jadwal[0] ?? '' }}"
                                                            placeholder="Pembentukan panitia kegiatan">
                                                    </td>
                                                    <td>
                                                        <div class="timeline-checkboxes d-flex flex-wrap gap-2">
                                                            @for ($i = 0; $i < 12; $i++)
                                                                @php
                                                                    $checked = false;
                                                                    if (
                                                                        is_array($jadwal) &&
                                                                        isset($jadwal['timeline']) &&
                                                                        is_array($jadwal['timeline'])
                                                                    ) {
                                                                        $checked =
                                                                            isset($jadwal['timeline'][$i]) &&
                                                                            $jadwal['timeline'][$i] == 1;
                                                                    } elseif (
                                                                        old('jadwal_timeline') &&
                                                                        isset(old('jadwal_timeline')[$index])
                                                                    ) {
                                                                        $timelineData = explode(
                                                                            ',',
                                                                            old('jadwal_timeline')[$index],
                                                                        );
                                                                        $checked =
                                                                            isset($timelineData[$i]) &&
                                                                            trim($timelineData[$i]) == '1';
                                                                    }
                                                                @endphp
                                                                <div class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input timeline-checkbox"
                                                                        data-week="{{ $i }}"
                                                                        {{ $checked ? 'checked' : '' }}>
                                                                    <label
                                                                        class="form-check-label small">{{ $i + 1 }}</label>
                                                                </div>
                                                            @endfor
                                                            <input type="hidden" name="jadwal_timeline[]"
                                                                class="timeline-hidden"
                                                                value="{{ is_array($jadwal) && isset($jadwal['timeline']) ? implode(',', $jadwal['timeline']) : old('jadwal_timeline')[$index] ?? '0,0,0,0,0,0,0,0,0,0,0,0' }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger removeJadwal">Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="jadwal-row">
                                                <td>
                                                    <input type="text" name="jadwal_nama[]" class="form-control"
                                                        placeholder="Pembentukan panitia kegiatan">
                                                </td>
                                                <td>
                                                    <div class="timeline-checkboxes d-flex flex-wrap gap-2">
                                                        @for ($i = 0; $i < 12; $i++)
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input timeline-checkbox"
                                                                    data-week="{{ $i }}">
                                                                <label
                                                                    class="form-check-label small">{{ $i + 1 }}</label>
                                                            </div>
                                                        @endfor
                                                        <input type="hidden" name="jadwal_timeline[]"
                                                            class="timeline-hidden" value="0,0,0,0,0,0,0,0,0,0,0,0">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger removeJadwal">Hapus</button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" id="addJadwal">Tambah Jadwal
                                Kegiatan</button>
                        </div>
                    </div>
                    <!-- Susunan Acara -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>Susunan Acara</h6>
                            <button type="button" class="btn btn-sm btn-primary" id="addAcara">Tambah Acara</button>
                        </div>
                        <div class="card-body">
                            <div id="acaraContainer">
                                @if (old('acara_waktu') || ($proposal && $proposal->susunan_acara))
                                    @php
                                        $acaraData = old('acara_waktu')
                                            ? array_map(
                                                null,
                                                old('acara_waktu'),
                                                old('acara_kegiatan'),
                                                old('acara_pengisi'),
                                            )
                                            : $proposal->susunan_acara ?? [];
                                    @endphp
                                    @foreach ($acaraData as $acara)
                                        <div class="row mb-2 acara-row">
                                            <div class="col-md-3">
                                                <input type="text" name="acara_waktu[]" class="form-control"
                                                    value="{{ is_array($acara) ? $acara['waktu'] ?? '' : $acara[0] ?? '' }}"
                                                    placeholder="08.00 – 08.15">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="acara_kegiatan[]" class="form-control"
                                                    value="{{ is_array($acara) ? $acara['kegiatan'] ?? '' : $acara[1] ?? '' }}"
                                                    placeholder="Pembukaan">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="acara_pengisi[]" class="form-control"
                                                    value="{{ is_array($acara) ? $acara['pengisi'] ?? '' : $acara[2] ?? '' }}"
                                                    placeholder="MC">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removeAcara">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 acara-row">
                                        <div class="col-md-3">
                                            <input type="text" name="acara_waktu[]" class="form-control"
                                                placeholder="08.00 – 08.15">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="acara_kegiatan[]" class="form-control"
                                                placeholder="Pembukaan">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="acara_pengisi[]" class="form-control"
                                                placeholder="MC">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-sm btn-danger removeAcara">Hapus</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Biaya -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>IV. Biaya Yang Diperlukan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Deskripsi Biaya</label>
                                        <textarea name="deskripsi_biaya" class="form-control" rows="3" required
                                            placeholder="Kegiatan dibiayai oleh kampus berdasarkan RENJA...">{{ old('deskripsi_biaya', $proposal->deskripsi_biaya ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Judul Anggaran</label>
                                        <input type="text" name="judul_anggaran" class="form-control" required
                                            value="{{ old('judul_anggaran', $proposal->judul_anggaran ?? '') }}"
                                            placeholder="Kegiatan LKMM-TD Tahun 2023">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Total Anggaran</label>
                                        <input type="text" name="total_anggaran" class="form-control rupiah" required
                                            value="{{ old('total_anggaran', $proposal && $proposal->total_anggaran ? number_format($proposal->total_anggaran, 0, ',', '.') : '') }}"
                                            placeholder="2.825.000">
                                    </div>
                                </div>
                            </div>

                            <h6>Rincian Anggaran</h6>
                            <button type="button" class="btn btn-sm btn-primary mb-2" id="addAnggaran">Tambah
                                Item</button>
                            <div id="anggaranContainer">
                                @if (old('anggaran_uraian') || ($proposal && $proposal->anggaran_belanja))
                                    @php
                                        $anggaranData = old('anggaran_uraian')
                                            ? array_map(
                                                null,
                                                old('anggaran_akun'),
                                                old('anggaran_kategori'),
                                                old('anggaran_uraian'),
                                                old('anggaran_rincian'),
                                                old('anggaran_total_barang'),
                                                old('anggaran_qty'),
                                                old('anggaran_harga'),
                                            )
                                            : $proposal->anggaran_belanja ?? [];
                                    @endphp
                                    @foreach ($anggaranData as $anggaran)
                                        <div class="row mb-2 anggaran-row">
                                            <div class="col-md-2">
                                                <input type="text" name="anggaran_akun[]" class="form-control"
                                                    value="{{ is_array($anggaran) ? $anggaran['akun'] ?? '' : $anggaran[0] ?? '' }}"
                                                    placeholder="525112">
                                                <small class="text-muted">Akun</small>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="anggaran_kategori[]" class="form-control">
                                                    <option value="">Pilih Kategori</option>
                                                    <option value="Belanja Barang"
                                                        {{ (is_array($anggaran) ? $anggaran['kategori'] ?? '' : $anggaran[1] ?? '') == 'Belanja Barang' ? 'selected' : '' }}>
                                                        Belanja Barang</option>
                                                    <option value="Belanja Jasa"
                                                        {{ (is_array($anggaran) ? $anggaran['kategori'] ?? '' : $anggaran[1] ?? '') == 'Belanja Jasa' ? 'selected' : '' }}>
                                                        Belanja Jasa</option>
                                                    <option value="Belanja Perjalanan"
                                                        {{ (is_array($anggaran) ? $anggaran['kategori'] ?? '' : $anggaran[1] ?? '') == 'Belanja Perjalanan' ? 'selected' : '' }}>
                                                        Belanja Perjalanan</option>
                                                </select>
                                                <small class="text-muted">Kategori</small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="anggaran_uraian[]" class="form-control"
                                                    value="{{ is_array($anggaran) ? $anggaran['uraian'] ?? '' : $anggaran[2] ?? '' }}"
                                                    placeholder="Biaya cetak/jilid/penggandaan LKMM">
                                                <small class="text-muted">Uraian</small>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="anggaran_rincian[]" class="form-control"
                                                    value="{{ is_array($anggaran) ? $anggaran['rincian'] ?? '' : $anggaran[3] ?? '' }}"
                                                    placeholder="3 Jilid">
                                                <small class="text-muted">Rincian</small>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="anggaran_total_barang[]" class="form-control"
                                                    value="{{ is_array($anggaran) ? $anggaran['total_barang'] ?? '' : $anggaran[4] ?? '' }}"
                                                    placeholder="3">
                                                <small class="text-muted">Total</small>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="anggaran_qty[]" class="form-control"
                                                    value="{{ is_array($anggaran) ? $anggaran['qty'] ?? '' : $anggaran[5] ?? '' }}"
                                                    placeholder="3">
                                                <small class="text-muted">Qty</small>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="anggaran_harga[]"
                                                    class="form-control rupiah-small"
                                                    value="{{ is_array($anggaran) ? (isset($anggaran['harga_satuan']) ? number_format($anggaran['harga_satuan'], 0, ',', '.') : '') : $anggaran[6] ?? '' }}"
                                                    placeholder="20.000">
                                                <small class="text-muted">Harga Satuan</small>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removeAnggaran">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 anggaran-row">
                                        <div class="col-md-2">
                                            <input type="text" name="anggaran_akun[]" class="form-control"
                                                placeholder="525112">
                                            <small class="text-muted">Akun</small>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="anggaran_kategori[]" class="form-control">
                                                <option value="">Pilih Kategori</option>
                                                <option value="Belanja Barang">Belanja Barang</option>
                                                <option value="Belanja Jasa">Belanja Jasa</option>
                                                <option value="Belanja Perjalanan">Belanja Perjalanan</option>
                                            </select>
                                            <small class="text-muted">Kategori</small>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="anggaran_uraian[]" class="form-control"
                                                placeholder="Biaya cetak/jilid/penggandaan LKMM">
                                            <small class="text-muted">Uraian</small>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="anggaran_rincian[]" class="form-control"
                                                placeholder="3 Jilid">
                                            <small class="text-muted">Rincian</small>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="anggaran_total_barang[]" class="form-control"
                                                placeholder="3">
                                            <small class="text-muted">Total</small>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="anggaran_qty[]" class="form-control"
                                                placeholder="3">
                                            <small class="text-muted">Qty</small>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="anggaran_harga[]"
                                                class="form-control rupiah-small" placeholder="20.000">
                                            <small class="text-muted">Harga Satuan</small>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button"
                                                class="btn btn-sm btn-danger removeAnggaran">Hapus</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Susunan Kepanitiaan -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6>V. Susunan Kepanitiaan</h6>
                            <button type="button" class="btn btn-sm btn-primary" id="addPanitia">Tambah Panitia</button>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Judul Kepanitiaan</label>
                                <input type="text" name="judul_kepanitiaan" class="form-control" required
                                    value="{{ old('judul_kepanitiaan', $proposal->judul_kepanitiaan ?? '') }}"
                                    placeholder="LKMM-TD Tahun 2023">
                            </div>

                            <div id="panitiaContainer">
                                @if (old('panitia_nama') || ($proposal && $proposal->susunan_kepanitiaan))
                                    @php
                                        $panitiaData = old('panitia_nama')
                                            ? array_map(
                                                null,
                                                old('panitia_nama'),
                                                old('panitia_nim'),
                                                old('panitia_prodi'),
                                                old('panitia_jabatan'),
                                            )
                                            : $proposal->susunan_kepanitiaan ?? [];
                                    @endphp
                                    @foreach ($panitiaData as $panitia)
                                        <div class="row mb-2 panitia-row">
                                            <div class="col-md-3">
                                                <input type="text" name="panitia_nama[]" class="form-control"
                                                    value="{{ is_array($panitia) ? $panitia['nama'] ?? '' : $panitia[0] ?? '' }}"
                                                    placeholder="Tegar Darmawan">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="panitia_nim[]" class="form-control"
                                                    value="{{ is_array($panitia) ? $panitia['nim'] ?? '' : $panitia[1] ?? '' }}"
                                                    placeholder="2131730078">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="panitia_prodi[]" class="form-control"
                                                    value="{{ is_array($panitia) ? $panitia['prodi'] ?? '' : $panitia[2] ?? '' }}"
                                                    placeholder="MI">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="panitia_jabatan[]" class="form-control"
                                                    value="{{ is_array($panitia) ? $panitia['jabatan'] ?? '' : $panitia[3] ?? '' }}"
                                                    placeholder="Penanggung Jawab">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removePanitia">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 panitia-row">
                                        <div class="col-md-3">
                                            <input type="text" name="panitia_nama[]" class="form-control"
                                                placeholder="Tegar Darmawan">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="panitia_nim[]" class="form-control"
                                                placeholder="2131730078">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="panitia_prodi[]" class="form-control"
                                                placeholder="MI">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="panitia_jabatan[]" class="form-control"
                                                placeholder="Penanggung Jawab">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-sm btn-danger removePanitia">Hapus</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Proposal</button>
                        {{-- <a href="{{ route('user.jadwal.show', $jadwal->id) }}" class="btn btn-secondary">Batal</a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format rupiah
            function formatRupiah(angka, prefix = '') {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
            }

            // Event listener untuk format rupiah
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('rupiah') || e.target.classList.contains('rupiah-small')) {
                    e.target.value = formatRupiah(e.target.value);
                }
            });

            // Tambah Materi
            document.getElementById('addMateri').addEventListener('click', function() {
                const container = document.getElementById('materiContainer');
                const newRow = document.createElement('div');
                newRow.className = 'row mb-2 materi-row';
                newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" name="materi_nama[]" class="form-control" placeholder="Materi 1">
            </div>
            <div class="col-md-4">
                <input type="text" name="materi_judul[]" class="form-control" placeholder="Dasar-Dasar Organisasi">
            </div>
            <div class="col-md-4">
                <input type="text" name="materi_pemateri[]" class="form-control" placeholder="Ilham Hadi Kurniawan">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-danger removeMateri">Hapus</button>
            </div>
        `;
                container.appendChild(newRow);
            });

            // Hapus
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeMateri')) {
                    e.target.closest('.materi-row').remove();
                }
            });

            // Tambah Acara
            document.getElementById('addAcara').addEventListener('click', function() {
                const container = document.getElementById('acaraContainer');
                const newRow = document.createElement('div');
                newRow.className = 'row mb-2 acara-row';
                newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="acara_waktu[]" class="form-control" placeholder="08.00 – 08.15">
            </div>
            <div class="col-md-4">
                <input type="text" name="acara_kegiatan[]" class="form-control" placeholder="Pembukaan">
            </div>
            <div class="col-md-3">
                <input type="text" name="acara_pengisi[]" class="form-control" placeholder="MC">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-danger removeAcara">Hapus</button>
            </div>
        `;
                container.appendChild(newRow);
            });

            // Hapus Acara
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeAcara')) {
                    e.target.closest('.acara-row').remove();
                }
            });

            // Tambah Anggaran
            document.getElementById('addAnggaran').addEventListener('click', function() {
                const container = document.getElementById('anggaranContainer');
                const newRow = document.createElement('div');
                newRow.className = 'row mb-2 anggaran-row';
                newRow.innerHTML = `
        <div class="col-md-2">
            <input type="text" name="anggaran_akun[]" class="form-control" placeholder="525112">
            <small class="text-muted">Akun</small>
        </div>
        <div class="col-md-2">
            <select name="anggaran_kategori[]" class="form-control">
                <option value="">Pilih Kategori</option>
                <option value="Belanja Barang">Belanja Barang</option>
                <option value="Belanja Jasa">Belanja Jasa</option>
                <option value="Belanja Perjalanan">Belanja Perjalanan</option>
            </select>
            <small class="text-muted">Kategori</small>
        </div>
        <div class="col-md-3">
            <input type="text" name="anggaran_uraian[]" class="form-control" placeholder="Biaya cetak/jilid/penggandaan LKMM">
            <small class="text-muted">Uraian</small>
        </div>
        <div class="col-md-2">
            <input type="text" name="anggaran_rincian[]" class="form-control" placeholder="3 Jilid">
            <small class="text-muted">Rincian</small>
        </div>
        <div class="col-md-1">
            <input type="number" name="anggaran_total_barang[]" class="form-control" placeholder="3">
            <small class="text-muted">Total</small>
        </div>
        <div class="col-md-1">
            <input type="number" name="anggaran_qty[]" class="form-control" placeholder="3">
            <small class="text-muted">Qty</small>
        </div>
        <div class="col-md-2">
            <input type="text" name="anggaran_harga[]" class="form-control rupiah-small" placeholder="20.000">
            <small class="text-muted">Harga Satuan</small>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger removeAnggaran">Hapus</button>
        </div>
    `;
                container.appendChild(newRow);
            });

            // Hapus Anggaran
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeAnggaran')) {
                    e.target.closest('.anggaran-row').remove();
                }
            });

            // Tambah Panitia
            document.getElementById('addPanitia').addEventListener('click', function() {
                const container = document.getElementById('panitiaContainer');
                const newRow = document.createElement('div');
                newRow.className = 'row mb-2 panitia-row';
                newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="panitia_nama[]" class="form-control" placeholder="Tegar Darmawan">
            </div>
            <div class="col-md-2">
                <input type="text" name="panitia_nim[]" class="form-control" placeholder="2131730078">
            </div>
            <div class="col-md-2">
                <input type="text" name="panitia_prodi[]" class="form-control" placeholder="MI">
            </div>
            <div class="col-md-3">
                <input type="text" name="panitia_jabatan[]" class="form-control" placeholder="Penanggung Jawab">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-danger removePanitia">Hapus</button>
            </div>
        `;
                container.appendChild(newRow);
            });

            // Hapus Panitia
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removePanitia')) {
                    e.target.closest('.panitia-row').remove();
                }
            });

            function updateTimelineInput(row) {
                const checkboxes = row.querySelectorAll('.timeline-checkbox');
                const hiddenInput = row.querySelector('.timeline-hidden');
                const values = [];

                checkboxes.forEach(checkbox => {
                    values.push(checkbox.checked ? '1' : '0');
                });

                hiddenInput.value = values.join(',');
            }

            // Event listener untuk checkbox timeline
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('timeline-checkbox')) {
                    const row = e.target.closest('.jadwal-row');
                    updateTimelineInput(row);
                }
            });

            // Tambah Jadwal Kegiatan
            document.getElementById('addJadwal').addEventListener('click', function() {
                const container = document.getElementById('jadwalContainer');
                const newRow = document.createElement('tr');
                newRow.className = 'jadwal-row';

                let checkboxHtml = '';
                for (let i = 0; i < 12; i++) {
                    checkboxHtml += `
                <div class="form-check">
                    <input type="checkbox" class="form-check-input timeline-checkbox" data-week="${i}">
                    <label class="form-check-label small">${i + 1}</label>
                </div>
            `;
                }

                newRow.innerHTML = `
            <td>
                <input type="text" name="jadwal_nama[]" class="form-control" 
                    placeholder="Pembentukan panitia kegiatan">
            </td>
            <td>
                <div class="timeline-checkboxes d-flex flex-wrap gap-2">
                    ${checkboxHtml}
                    <input type="hidden" name="jadwal_timeline[]" class="timeline-hidden" 
                        value="0,0,0,0,0,0,0,0,0,0,0,0">
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger removeJadwal">Hapus</button>
            </td>
        `;
                container.appendChild(newRow);
            });

            // Hapus Jadwal
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeJadwal')) {
                    e.target.closest('.jadwal-row').remove();
                }
            });
        });
    </script>

@endsection
