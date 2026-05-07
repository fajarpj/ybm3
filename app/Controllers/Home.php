<?php

namespace App\Controllers;

class Home extends BaseController
{
    private array $site = [
        'name'        => 'Yayasan Kolaborasi Nusantara',
        'tagline'     => 'Ruang tumbuh untuk pendidikan, kesehatan, dan pemberdayaan warga.',
        'email'       => 'halo@yayasankolaborasi.org',
        'phone'       => '+62 812-3456-7890',
        'address'     => 'Jl. Gotong Royong No. 24, Jakarta',
        'heroMetrics' => [
            ['value' => '12+', 'label' => 'program aktif'],
            ['value' => '350+', 'label' => 'penerima manfaat'],
            ['value' => '18', 'label' => 'mitra kolaborasi'],
        ],
        'focusAreas'  => [
            [
                'title'       => 'Pendidikan Inklusif',
                'description' => 'Pendampingan belajar, kelas literasi digital, dan beasiswa mikro untuk pelajar yang membutuhkan.',
            ],
            [
                'title'       => 'Kesehatan Komunitas',
                'description' => 'Edukasi hidup sehat, pemeriksaan dasar berkala, dan dukungan gizi untuk keluarga rentan.',
            ],
            [
                'title'       => 'Pemberdayaan Ekonomi',
                'description' => 'Pelatihan usaha kecil, pendampingan pemasaran, dan penguatan kelompok usaha lokal.',
            ],
        ],
    ];

    public function index(): string
    {
        return view('pages/home', $this->pageData([
            'title'       => 'Beranda',
            'description' => 'Website profil yayasan berbasis CodeIgniter 4 untuk menampilkan program, dampak, dan ajakan kolaborasi.',
            'highlights'  => [
                'Kami merancang program yang dekat dengan kebutuhan komunitas.',
                'Setiap kegiatan dibangun bersama relawan, mitra, dan warga setempat.',
                'Model pengelolaan kami memudahkan tim untuk berkembang secara bertahap.',
            ],
        ]));
    }

    public function about(): string
    {
        return view('pages/about', $this->pageData([
            'title'       => 'Tentang Kami',
            'description' => 'Mengenal visi, cara kerja, dan nilai kolaborasi yayasan.',
            'principles'  => [
                'Bekerja dari kebutuhan nyata di lapangan, bukan asumsi.',
                'Mengutamakan kemitraan jangka panjang dan transparansi.',
                'Mendesain program yang bisa diteruskan dan ditingkatkan tim internal.',
            ],
        ]));
    }

    public function programs(): string
    {
        return view('pages/programs', $this->pageData([
            'title'       => 'Program',
            'description' => 'Ringkasan program prioritas yang sedang dijalankan yayasan.',
            'programs'    => [
                [
                    'name'    => 'Kelas Sore Komunitas',
                    'summary' => 'Ruang belajar selepas sekolah dengan materi literasi, numerasi, dan pendampingan tugas.',
                    'impact'  => 'Menjangkau 120 anak di 4 titik belajar.',
                ],
                [
                    'name'    => 'Pos Sehat Warga',
                    'summary' => 'Kegiatan pemeriksaan kesehatan dasar dan edukasi pencegahan penyakit untuk keluarga.',
                    'impact'  => 'Melibatkan 9 tenaga kesehatan dan 2 komunitas lokal.',
                ],
                [
                    'name'    => 'Inkubasi UMKM Mikro',
                    'summary' => 'Pelatihan produk, pencatatan usaha, dan promosi digital untuk pelaku usaha kecil.',
                    'impact'  => 'Mendampingi 36 usaha rumahan selama 6 bulan.',
                ],
            ],
        ]));
    }

    public function contact(): string
    {
        return view('pages/contact', $this->pageData([
            'title'       => 'Kontak',
            'description' => 'Hubungi kami untuk kolaborasi program, dukungan, atau kunjungan lapangan.',
        ]));
    }

    private function pageData(array $data = []): array
    {
        return array_merge([
            'site'       => $this->site,
            'currentUri' => service('request')->getUri()->getPath(),
        ], $data);
    }
}
