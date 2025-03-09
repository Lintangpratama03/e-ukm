<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Pengesahan Proposal LKMM-TD</title>
    <style>
        body {
            font-family: Times New Roman, serif;
            max-width: 700px;
            margin: 0 auto;
            margin-left: 60px;
            padding: 40px;
            line-height: 1.3;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 70px;
            font-size: 16px;
            line-height: 1.5;
        }

        .content {
            width: 100%;
            margin-bottom: 30px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0;
            vertical-align: top;
        }

        .label {
            width: 150px;
        }

        .colon {
            width: 15px;
            text-align: center;
        }

        .value {
            text-align: left;
            padding-left: 10px;
        }

        /* Completely revised signature section to match image */
        .signatures {
            width: 100%;
            position: relative;
            margin-top: 30px;
            font-size: 14px;
        }

        .left-sig {
            position: absolute;
            left: 0;
            top: 0;
            text-align: left;
        }

        .right-sig {
            position: absolute;
            right: 0;
            top: 0;
            text-align: left;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 80px;
            /* Increased space for signature */
        }

        .approval {
            text-align: center;
            margin-top: 180px;
            /* Increased to accommodate signature space */
            font-size: 14px;
        }

        .coordinator-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 80px;
        }

        .italic {
            font-style: italic;
        }

        ol {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="title">
        LEMBAR PENGESAHAN<br>
        PROPOSAL PELAKSANAAN KEGIATAN {{ $lembarPengesahan->nama_kegiatan }}
    </div>

    <div class="content">
        <table>
            <tr>
                <td class="label">Kementerian</td>
                <td class="colon">:</td>
                <td class="value"><b>042 Kementerian Pendidikan dan Kebudayaan</b></td>
            </tr>
            <tr>
                <td class="label">Unit Eselon I</td>
                <td class="colon">:</td>
                <td class="value"><b>01 Sekretariat Jenderal Kementerian Riset, Teknologi dan Pendidikan Tinggi</b>
                </td>
            </tr>
            <tr>
                <td class="label">Unit Kerja</td>
                <td class="colon">:</td>
                <td class="value"><b>401004 Politeknik Negeri Malang</b></td>
            </tr>
            <tr>
                <td class="label">Kegiatan</td>
                <td class="colon">:</td>
                <td class="value">{{ $lembarPengesahan->nama_kegiatan }}</td>
            </tr>
            <tr>
                <td class="label">Sasaran</td>
                <td class="colon">:</td>
                <td class="value">{{ $lembarPengesahan->sasaran }}</td>
            </tr>
            <tr>
                <td class="label">Program</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $lembarPengesahan->program }}
                </td>
            </tr>
            <tr>
                <td class="label">Indikator Kerja</td>
                <td class="colon">:</td>
                <td class="value">{{ $lembarPengesahan->indikator_kerja }}</td>
            </tr>
            <tr>
                <td class="label">Volume</td>
                <td class="colon">:</td>
                <td class="value">1. {{ $lembarPengesahan->peserta }}<span
                        class="italic">({{ App\Helpers\Terbilang::make($lembarPengesahan->peserta) }})</span> ; 2. 1
                    (satu)</td>
            </tr>
            <tr>
                <td class="label">Satuan Ukur</td>
                <td class="colon">:</td>
                <td class="value">1. Peserta ; 2. Dokumen</td>
            </tr>
            <tr>
                <td class="label">Tanggal Pelaksanaan</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($lembarPengesahan->tanggal_pelaksanaan)->locale('id')->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td class="label">Jumlah Dana</td>
                <td class="colon">:</td>
                <td class="value">
                    <b>{{ number_format($lembarPengesahan->jumlah_dana, 0, ',', '.') }},-</b>
                    <span class="italic">({{ App\Helpers\Terbilang::make($lembarPengesahan->jumlah_dana) }}
                        rupiah)</span>
                </td>
            </tr>
            <tr>
                <td class="label">Sumber Dana</td>
                <td class="colon">:</td>
                <td class="value">APBN/BLU berdasarkan RENJA Unit Kerja PSDKU Polinema Kota Kediri</td>
            </tr>
        </table>
    </div>
    <br><br>
    <div class="signatures">
        <div class="left-sig">
            <br>
            <div>Dosen Pembina Kemahasiswaan,</div>
            <div class="signature-name">
                @if ($lembarPengesahan->dpk == 'dony')
                    Ahmad Dony Mutiara Bahtiar, S.T., M.T.
                @elseif($lembarPengesahan->dpk == 'ratna')
                    Ratna Widyastuti. S.Pd., M.Pd
                @endif
            </div>
            <div>
                @if ($lembarPengesahan->dpk == 'dony')
                    NIDN: 0715068203
                @elseif($lembarPengesahan->dpk == 'ratna')
                    NIDN: 0730048901
                @endif
            </div>
        </div>

        <div class="right-sig">
            <div>Kediri, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
            <div>Ketua Pelaksana,</div>
            <div class="signature-name">{{ $lembarPengesahan->ketua_pelaksana }}</div>
            <div>NIM. {{ $lembarPengesahan->nim_ketua_pelaksana }}</div>
        </div>
    </div>

    <div class="approval">
        <div>Menyetujui,</div>
        <div>Koordinator Pengelola Kampus Kediri,</div>
        <div class="coordinator-name">Drs. M. Arief Setiawan, M.Kom</div>
        <div>NIP: 196611181993031001</div>
    </div>
</body>

</html>
