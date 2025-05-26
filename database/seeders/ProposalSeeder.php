<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        Proposal::create([
            'jadwal_id' => 1,
            'kegiatan_singkat' => 'LKMM-TD',
            'kegiatan_lengkap' => 'LATIHAN KETERAMPILAN MANAJEMEN MAHASISWA TINGKAT DASAR PSDKU POLITEKNIK NEGERI MALANG DI KOTA KEDIRI TAHUN 2023',
            'nama_penyusun' => 'Abyan Syahrul Rifai',
            'nim_penyusun' => '2141280005',
            'nama_institusi' => 'BADAN EKSEKUTIF MAHASISWA PSDKU POLITEKNIK NEGERI MALANG DI KOTA KEDIRI',
            'tahun' => 2023,
           
            'dasar_kegiatan' => [
                'UUD Negara Republik Indonesia Tahun 1945.',
                'UU No. 20 Tahun 2003 tentang Sistem Pendidikan Nasional.',
                'UU No. 12 Tahun 2012 tentang Pendidikan Tinggi.',
                'PP No. 4 Tahun 2014 tentag Penyelenggaraan dan Pengelolaan Perguruan Tinggi.',
                'Peraturan Menteri Pendidikan dan Kebudayaan No. 139 Tahun 2014 tentang Pedoman Statuta dan Organisasai Perguruan Tinggi.',
                'Tridharma Perguruan Tinggi.',
                'Surat Keputusan Direktur Polinema Nomor 149 Tahun 2021.',
                'Sidang Pleno 4 BEM PSDKU Polinema di Kota Kediri.'
            ],
            'gambaran_umum' => 'Mahasiswa merupakan penerus perjuangan bangsa yang nantinya akan mengemban tampuk pimpinan bangsa, baik saat berada didalam masyarakat maupun bernegara. Mahasiswa juga diperhadapkan pada persaingan global dan kesempatan kerja yang semakin sempit dan kompetitif. Dari dasar pemikiran tersebut maka perlu disiapkan mulai sekarang individu yang handal baik dari segi mental, kemampuan intelektual dan keunggulan keterampilan yang kemudian akan dipergunakan sebagai nilai tambah dari lulusan perguruan tinggi.',
            'penerima_manfaat' => 'Penerima manfaat langsung dari pelaksanaan kegiatan Latihan Keterampilan Manajemen Mahasiswa Tingkat Dasar ini adalah seluruh mahasiswa tingkat 1 PSDKU Politeknik Negeri Malang di Kota Kediri.',
            'metode_pelaksanaan' => [
                'Peserta melakukan pendaftaraan dengan meingisi gform yang tertera pada pamflet yang telah di share.',
                'Peserta join grup whatsapps melalui link yang tertera di bagian akhir gform pendaftaraan.',
                'Seluruh informasi terkait juknis dan ketentuan LKMM TD akan di informasikan panitia melalui grub peserta.',
                'Link Zoom akan dibagikan ke peserta 30 menit sebelum acara dimulai melalui grup whatsapps peserta.',
                'Peserta dapat bergabung apabila format nama sudah sesuai ketentuan yang telah panitia pelaksana buat.'
            ],
            'tahapan_pelaksanaan' => [
                'Pembentukan panitia kegiatan perancangan kegiatan LKMM-TD.',
                'Pengajuan proposal kegiatan LKMM-TD.',
                'Pelaksanaan kegiatan LKMM-TD.',
                'Pelaporan dan pertanggungjawaban pelaksanaan kegiatan LKMM-TD.'
            ],
            'deskripsi_waktu_pelaksanaan' => 'Waktu pelaksanaan kegiatan Latihan Keterampilan Manajemen Mahasiswa Tingkat Dasar PSDKU Politeknik Negeri Malang di Kota Kediri Tahun 2023 mengacu pada tahapan pelaksanaan tersebut di atas.',
            'bulan_headers' => ['April', 'Mei', 'Juni'],
            'jadwal_kegiatan' => [
                [
                    'nama' => 'Pembentukan panitia kegiatan LKMM-TD',
                    'timeline' => [0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0]
                ],
                [
                    'nama' => 'Pengajuan proposal kegiatan LKMM-TD',
                    'timeline' => [0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0]
                ],
                [
                    'nama' => 'Pelaksanaan kegiatan LKMM-TD',
                    'timeline' => [0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0]
                ],
                [
                    'nama' => 'Pelaporan dan pertanggungjawaban pelaksanaan kegiatan LKMM-TD',
                    'timeline' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1]
                ]
            ],
            'kurun_waktu_pencapaian' => 'Kegiatan Latihan Keterampilan Manajemen Mahasiswa Tingkat Dasar akan dilaksanakan pada tanggal 20 Mei dan 10 Juni 2023, oleh karena itu kurun waktu pencapaian keluaran adalah 2 (dua) hari.',
            'deskripsi_materi_kegiatan' => 'Kegiatan Latihan Keterampilan Manajemen Mahasiswa Tingkat Dasar PSDKU Politeknik Negeri Malang di Kota Kediri terdiri dari pemberian materi secara online:',
            'materi_kegiatan' => [
                [
                    'nama' => 'Materi 1',
                    'judul' => 'Dasar-Dasar Organisasi',
                    'pemateri' => 'Ilham Hadi Kurniawan'
                ],
                [
                    'nama' => 'Materi 2',
                    'judul' => 'Pengambilan Keputusan',
                    'pemateri' => 'Odie Zainal Makhali'
                ],
                [
                    'nama' => 'Materi 3',
                    'judul' => 'Komunikasi Antar Unit Kerja',
                    'pemateri' => 'Aurent Savila Yosti Putri'
                ]
            ],
            'hari_tanggal_acara' => 'Sabtu, 20 Mei dan 10 Juni 2023',
            'susunan_acara' => [
                ['waktu' => '08.00 – 08.15', 'kegiatan' => 'Pembukaan', 'pengisi' => 'MC'],
                ['waktu' => '08.15 – 08.20', 'kegiatan' => 'Menyanyikan lagu Indonesia Raya', 'pengisi' => 'MC'],
                ['waktu' => '08.20 – 08.25', 'kegiatan' => 'Menyanyikan lagu Mars Polinema', 'pengisi' => 'MC'],
                ['waktu' => '08.25 – 08.35', 'kegiatan' => 'Menyanyikan lagu Mars Mahasiswa', 'pengisi' => 'MC'],
                ['waktu' => '08.35 – 08.40', 'kegiatan' => 'Sambutan Ketua Pelaksana', 'pengisi' => 'Ketua Pelaksana'],
                ['waktu' => '08.40 – 08.45', 'kegiatan' => 'Sambutan Ketua BEM', 'pengisi' => 'Ketua BEM'],
                ['waktu' => '08.45 – 09.00', 'kegiatan' => 'Sambutan Koordinator', 'pengisi' => 'Koordinator'],
                ['waktu' => '09.00 – 09.10', 'kegiatan' => 'Pembacaan tata tertib', 'pengisi' => 'Moderator'],
                ['waktu' => '09.10 – 10.10', 'kegiatan' => 'Pemaparan materi 1', 'pengisi' => 'Pemateri 1: Ilham Hadi Kurniawan'],
                ['waktu' => '10.10 – 10.30', 'kegiatan' => 'Tanya jawab dan foto bersama', 'pengisi' => 'Moderator'],
                ['waktu' => '10.30 – 10.40', 'kegiatan' => 'Absensi ke-1', 'pengisi' => 'Moderator'],
                ['waktu' => '10.40 – 11.40', 'kegiatan' => 'Pemaparan materi 2', 'pengisi' => 'Pemateri 2: Odie Zainal Makhali'],
                ['waktu' => '11.40 – 12.00', 'kegiatan' => 'Tanya jawab dan foto bersama', 'pengisi' => 'Moderator'],
                ['waktu' => '12.00 – 12.10', 'kegiatan' => 'Absensi ke-2', 'pengisi' => 'Moderator'],
                ['waktu' => '12.10 – 13.10', 'kegiatan' => 'Ishoma dan kuiz', 'pengisi' => 'Moderator'],
                ['waktu' => '13.10 – 14.10', 'kegiatan' => 'Pemaparan materi 3', 'pengisi' => 'Pemateri 3: Aurent Savila Yosti Putri'],
                ['waktu' => '14.10 – 14.30', 'kegiatan' => 'Tanya jawab dan foto bersama', 'pengisi' => 'Moderator'],
                ['waktu' => '14.30 – 14.40', 'kegiatan' => 'Absensi ke-3', 'pengisi' => 'Moderator'],
                ['waktu' => '14.40 – 14.50', 'kegiatan' => 'Pembacaan kesimpulan', 'pengisi' => 'Moderator'],
                ['waktu' => '14.50 – 15.00', 'kegiatan' => 'Penutup', 'pengisi' => 'MC']
            ],
            'deskripsi_biaya' => 'Kegiatan Latihan Keterampilan Manajemen Mahasiswa Tingkat Dasar PSDKU Politeknik Negeri Malang di Kota Kediri Tahun 2023 dibiayai oleh kampus PSDKU Politeknik Negeri Malang di Kota Kediri, berdasarkan RENJA Unit Kerja PSDKU Polinema Kota Kediri, yaitu sebesar Rp2.825.000,- (Dua Juta Delapan Ratus Dua Puluh Lima Ribu Rupiah).',
            'judul_anggaran' => 'Kegiatan LKMM-TD Tahun 2023',
            'anggaran_belanja' => [
                [
                    'akun' => '525112',
                    'kategori' => 'Belanja Barang',
                    'uraian' => 'Biaya cetak/jilid/penggandaan LKMM - Penggandaan Proposal',
                    'rincian' => '3 Jilid',
                    'total_barang' => '3',
                    'qty' => '3',
                    'harga_satuan' => 20000,
                    'total_harga' => 60000,
                    'harga_satuan_format' => 'Rp20.000',
                    'total_harga_format' => 'Rp60.000'
                ],
                [
                    'akun' => '525112',
                    'kategori' => 'Belanja Barang',
                    'uraian' => 'Biaya cetak/jilid/penggandaan LKMM - Penggandaan LPJ',
                    'rincian' => '3 Jilid',
                    'total_barang' => '3',
                    'qty' => '3',
                    'harga_satuan' => 30000,
                    'total_harga' => 90000,
                    'harga_satuan_format' => 'Rp30.000',
                    'total_harga_format' => 'Rp90.000'
                ],
                [
                    'akun' => '525112',
                    'kategori' => 'Belanja Barang',
                    'uraian' => 'Biaya cetak/jilid/penggandaan LKMM- Cetak Sertifikat',
                    'rincian' => '550 Lembar',
                    'total_barang' => '550',
                    'qty' => '550',
                    'harga_satuan' => 1000,
                    'total_harga' => 550000,
                    'harga_satuan_format' => 'Rp1.000',
                    'total_harga_format' => 'Rp550.000'
                ],
                [
                    'akun' => '525113',
                    'kategori' => 'Belanja Jasa',
                    'uraian' => 'Honorarium Narasumber Eksternal LKMM - Honor Pemateri',
                    'rincian' => '3 Orang',
                    'total_barang' => '3',
                    'qty' => '3',
                    'harga_satuan' => 500000,
                    'total_harga' => 1500000,
                    'harga_satuan_format' => 'Rp500.000',
                    'total_harga_format' => 'Rp1.500.000'
                ],
                [
                    'akun' => '525115',
                    'kategori' => 'Belanja Perjalanan',
                    'uraian' => 'Transport Lokal LKMM - Transportasi panitia mahasiswa',
                    'rincian' => '25 Orang',
                    'total_barang' => '25',
                    'qty' => '25',
                    'harga_satuan' => 25000,
                    'total_harga' => 625000,
                    'harga_satuan_format' => 'Rp25.000',
                    'total_harga_format' => 'Rp625.000'
                ]
            ],
            'total_anggaran' => 2825000,
            'judul_kepanitiaan' => 'LKMM-TD Tahun 2023',
            'susunan_kepanitiaan' => [
                ['nama' => 'Tegar Darmawan', 'nim' => '2131730078', 'prodi' => 'MI', 'jabatan' => 'Penanggung Jawab'],
                ['nama' => 'Abyan Syahrul Rifai', 'nim' => '2141280005', 'prodi' => 'TMPP', 'jabatan' => 'Ketua Pelaksana'],
                ['nama' => 'Nor Halijah', 'nim' => '2132550010', 'prodi' => 'AKT', 'jabatan' => 'Sekretaris'],
                ['nama' => 'Yusmia Dira Agustin', 'nim' => '2132550106', 'prodi' => 'AKT', 'jabatan' => 'Bendahara'],
                ['nama' => 'Lintang Windy Pratama', 'nim' => '2131730057', 'prodi' => 'MI', 'jabatan' => 'CO Bidang Acara'],
                ['nama' => 'Itsna Rahma Fadlila', 'nim' => '2132550015', 'prodi' => 'AKT', 'jabatan' => 'Bidang Acara'],
                ['nama' => 'Mufidhatus Sofiyah', 'nim' => '2142570018', 'prodi' => 'KEU', 'jabatan' => 'Bidang Acara'],
                ['nama' => 'Muhammad Ilman Rusdian', 'nim' => '2131240116', 'prodi' => 'TM', 'jabatan' => 'Bidang Acara'],
                ['nama' => 'Rena Nazarulva Darma S.', 'nim' => '2131730064', 'prodi' => 'MI', 'jabatan' => 'Bidang Acara'],
                ['nama' => 'M. Haikal Shomadani', 'nim' => '2131240020', 'prodi' => 'TM', 'jabatan' => 'Bidang Acara'],
                ['nama' => 'Marchel Ryandika S.N', 'nim' => '2131240108', 'prodi' => 'TM', 'jabatan' => 'CO Bidang Humas'],
                ['nama' => 'Laura Dewi Nurviandra', 'nim' => '2131730107', 'prodi' => 'MI', 'jabatan' => 'Bidang Humas'],
                ['nama' => 'Sabrina Nahidah Raharjo', 'nim' => '2132550123', 'prodi' => 'AKT', 'jabatan' => 'Bidang Humas'],
                ['nama' => 'Silvia Amanda Widiarto', 'nim' => '2132550001', 'prodi' => 'AKT', 'jabatan' => 'Bidang Humas'],
                ['nama' => 'Lia Dewi Ariyanti', 'nim' => '2132550113', 'prodi' => 'AKT', 'jabatan' => 'Bidang Humas'],
                ['nama' => 'Hudyan Sultoni', 'nim' => '2141190058', 'prodi' => 'TE', 'jabatan' => 'Bidang Humas'],
                ['nama' => 'Naqsya Vidie Uluwiya', 'nim' => '2131730065', 'prodi' => 'MI', 'jabatan' => 'CO Bidang Dekdok'],
                ['nama' => 'Revaldy Aditya Pratama', 'nim' => '2141280030', 'prodi' => 'TMPP', 'jabatan' => 'Bidang Dekdok'],
                ['nama' => 'David Virge Hartono Putra', 'nim' => '2131240057', 'prodi' => 'TM', 'jabatan' => 'Bidang Dekdok'],
                ['nama' => 'Jundan Hawariyyun', 'nim' => '2141280002', 'prodi' => 'TMPP', 'jabatan' => 'Bidang Dekdok'],
                ['nama' => 'Saloom Mamluatul Aaliyah', 'nim' => '2132550050', 'prodi' => 'AKT', 'jabatan' => 'Bidang Dekdok'],
                ['nama' => 'Ahmad Alif Fajar', 'nim' => '2131730049', 'prodi' => 'MI', 'jabatan' => 'Bidang Dekdok'],
                ['nama' => 'Rahmatika Azhima', 'nim' => '2132550051', 'prodi' => 'AKT', 'jabatan' => 'Bidang Dekdok'],
                ['nama' => 'Zidan Aksa Mahendra', 'nim' => '2141190052', 'prodi' => 'TE', 'jabatan' => 'CO Bidang Pengawas'],
                ['nama' => 'Adi Fauzul Kurniawan', 'nim' => '2141190008', 'prodi' => 'TE', 'jabatan' => 'Bidang Pengawas'],
                ['nama' => 'Zafi Yuniar', 'nim' => '2142570049', 'prodi' => 'KEU', 'jabatan' => 'Bidang Pengawas'],
                ['nama' => 'M. Sulaiman', 'nim' => '2131240112', 'prodi' => 'TM', 'jabatan' => 'Bidang Pengawas'],
                ['nama' => 'Tifani Pualam Putri', 'nim' => '2141190058', 'prodi' => 'TE', 'jabatan' => 'Bidang Pengawas']
            ]
        ]);
    }
}
