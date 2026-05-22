<?php

namespace App\Controllers;

use App\Libraries\DonationStats;
use App\Libraries\MidtransGateway;
use App\Models\DonationModel;
use App\Models\GalleryModel;
use App\Models\ProgramModel;

class Home extends BaseController
{
    private array $site = [
        'name'         => 'Yayasan Bakti Mulya Masyarakat Mandiri',
        'shortName'    => 'YB3M Peduli',
        'tagline'      => 'Menguatkan bakti sosial, pendidikan, dan kemandirian umat melalui pengelolaan donasi yang amanah.',
        'address'      => 'Sekretariat Yayasan Bakti Mulya Masyarakat Mandiri, Indonesia.',
        'officeNote'   => 'Informasi operasional, program, dan penyaluran manfaat dikelola langsung oleh pengurus yayasan.',
        'email'        => 'admin@yb3mpeduli.org',
        'phone'        => '0853 5340 0700',
        'website'      => 'ybkb.org',
        'bankAccounts' => [
            ['bank' => 'BRI', 'number' => '6877-01-008170-53-3'],
            ['bank' => 'Mandiri', 'number' => '138-00-1874846-2'],
        ],
        'bankHolder'   => 'Yayasan Bakti Mulya Masyarakat Mandiri',
        'socials'      => [
            ['label' => 'Website', 'value' => 'ybkb.org', 'url' => 'https://ybkb.org'],
            ['label' => 'YouTube', 'value' => '@ybkbindonesia', 'url' => 'https://www.youtube.com/@ybkbindonesia'],
            ['label' => 'Instagram', 'value' => '@ybkbindonesia', 'url' => 'https://www.instagram.com/ybkbindonesia'],
        ],
        'heroMetrics'  => [
            ['value' => 'Amanah', 'label' => 'pengelolaan dana yang tertata'],
            ['value' => 'Peduli', 'label' => 'program sosial dan pembinaan umat'],
            ['value' => 'Mandiri', 'label' => 'arah pemberdayaan berkelanjutan'],
        ],
        'focusAreas'   => [
            [
                'title'       => 'Santunan dan Kepedulian Sosial',
                'description' => 'Penyaluran bantuan untuk masyarakat yang membutuhkan melalui aksi nyata yang penuh empati dan tanggung jawab.',
            ],
            [
                'title'       => 'Pendidikan dan Pembinaan',
                'description' => 'Penguatan ilmu, akhlak, dan pendampingan umat agar tumbuh menjadi pribadi yang bermanfaat bagi lingkungan sekitar.',
            ],
            [
                'title'       => 'Pemberdayaan Masyarakat Mandiri',
                'description' => 'Mendorong masyarakat memiliki daya tumbuh melalui program yang menumbuhkan semangat kerja, kolaborasi, dan kemandirian.',
            ],
        ],
    ];

    public function index(): string
    {
        $galleryModel = new GalleryModel();
        $donationStats = new DonationStats();
        $overview = $donationStats->getOverview();

        return view('pages/home', $this->pageData([
            'title'       => 'Beranda',
            'description' => 'Website resmi Yayasan Bakti Mulya Masyarakat Mandiri untuk profil yayasan, galeri kegiatan, dan donasi digital.',
            'bismillah'   => 'بِسْمِ اللهِ الرَّحْمَنِ الرَّحِيمِ',
            'greeting'    => 'السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ',
            'closing'     => 'وَالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ',
            'verse'       => 'Dan apabila hamba-hamba-Ku bertanya kepadamu (Muhammad) tentang Aku, maka sesungguhnya Aku dekat. Aku kabulkan permohonan orang yang berdoa apabila dia berdoa kepada-Ku. Hendaklah mereka itu memenuhi (perintah)-Ku dan beriman kepada-Ku, agar mereka memperoleh kebenaran. (QS. Al-Baqarah: 186)',
            'heroSlides'  => $galleryModel->where('is_published', 1)->where('category', 'home')->orderBy('id', 'ASC')->findAll(),
            'donationOverview' => $overview,
            'highlights'  => [
                [
                    'title'       => 'Profil yayasan yang lebih meyakinkan',
                    'description' => 'Beranda dirancang untuk memperkenalkan nama yayasan, semangat pelayanan, dan arah gerak lembaga dengan bahasa yang hangat.',
                ],
                [
                    'title'       => 'Galeri dokumentasi terpusat',
                    'description' => 'Dokumentasi kegiatan, pembagian bantuan, dan momen pembinaan dapat ditampilkan dalam satu menu galeri khusus.',
                ],
                [
                    'title'       => 'Donasi legal siap live',
                    'description' => 'Integrasi Midtrans disiapkan sebagai payment gateway resmi dan data transaksi disimpan ke database untuk dashboard admin maupun user.',
                ],
            ],
            'quickPrograms' => [
                'Program santunan untuk masyarakat yang membutuhkan.',
                'Kegiatan pembinaan, pendidikan, dan nilai-nilai keislaman.',
                'Program kemandirian untuk memperkuat kebermanfaatan jangka panjang.',
            ],
            'trustPoints' => [
                'Nama yayasan dan rekening resmi ditampilkan jelas pada halaman publik.',
                'Setiap program dapat dihubungkan dengan dokumentasi galeri dan progres donasi.',
                'Data donasi, user, dan status pembayaran tercatat ke dashboard.',
            ],
        ]));
    }

    public function about(): string
    {
        return view('pages/about', $this->pageData([
            'title'       => 'Tentang Kami',
            'description' => 'Mengenal identitas, nilai, dan arah pengabdian Yayasan Bakti Mulya Masyarakat Mandiri.',
            'principles'  => [
                'Menjaga amanah para donatur dan kepercayaan masyarakat.',
                'Mengutamakan manfaat nyata bagi umat dan lingkungan sekitar.',
                'Membangun semangat kemandirian melalui kerja sosial yang berkelanjutan.',
            ],
            'missions' => [
                'Menghadirkan program sosial yang menyentuh kebutuhan masyarakat secara langsung.',
                'Menguatkan pembinaan dan pendidikan sebagai fondasi perubahan yang baik.',
                'Mengembangkan sistem digital yayasan agar pengelolaan program dan donasi semakin tertib.',
            ],
        ]));
    }

    public function programs(): string
    {
        $programModel = new ProgramModel();
        $donationStats = new DonationStats();
        $paidMap = $donationStats->getPaidProgramMap();

        return view('pages/programs', $this->pageData([
            'title'       => 'Program',
            'description' => 'Ringkasan program utama Yayasan Bakti Mulya Masyarakat Mandiri yang dapat terus dikembangkan seiring perjalanan yayasan.',
            'programs'    => array_map(
                fn (array $program): array => $this->decorateProgram($program, $paidMap),
                $programModel->orderBy('id', 'DESC')->findAll()
            ),
        ]));
    }

    public function programDetail(string $slug): string
    {
        $programModel = new ProgramModel();
        $donationModel = new DonationModel();
        $donationStats = new DonationStats();
        $midtrans = new MidtransGateway();

        $program = $programModel->where('slug', $slug)->first();

        if (! $program) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $program = $this->decorateProgram($program, $donationStats->getPaidProgramMap());
        $recentDonors = $donationModel
            ->where('program_id', $program['id'])
            ->where('payment_status', 'paid')
            ->orderBy('paid_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll(10);

        return view('pages/program_detail', $this->pageData([
            'title'            => $program['judul'],
            'description'      => $program['deskripsi'],
            'program'          => $program,
            'recentDonors'     => $recentDonors,
            'midtransReady'    => $midtrans->isConfigured(),
            'gatewayOptions'   => ['Midtrans Snap'],
            'suggestedAmounts' => [50000, 100000, 250000, 500000],
        ]));
    }

    public function gallery(): string
    {
        $galleryModel = new GalleryModel();

        return view('pages/gallery', $this->pageData([
            'title'       => 'Gallery',
            'description' => 'Dokumentasi kegiatan, pembinaan, dan aksi sosial Yayasan Bakti Mulya Masyarakat Mandiri.',
            'galleries'   => $galleryModel->where('is_published', 1)->where('category', 'gallery')->orderBy('id', 'ASC')->findAll(),
        ]));
    }

    public function donation(): string
    {
        $programModel = new ProgramModel();
        $midtrans = new MidtransGateway();
        $donationStats = new DonationStats();
        $paidMap = $donationStats->getPaidProgramMap();
        $programs = array_map(
            fn (array $program): array => $this->decorateProgram($program, $paidMap),
            $programModel->where('status', 'aktif')->orderBy('id', 'DESC')->findAll()
        );

        return view('pages/donation', $this->pageData([
            'title'           => 'Donasi',
            'description'     => 'Salurkan donasi terbaik Anda untuk mendukung program Yayasan Bakti Mulya Masyarakat Mandiri.',
            'programOptions'  => $programs,
            'donationSteps'   => [
                'Login atau daftar agar donasi otomatis tercatat di dashboard user.',
                'Pilih nominal dan program, lalu lanjutkan pembayaran melalui Midtrans Snap.',
                'Admin dan user dapat memantau status transaksi dari dashboard secara langsung.',
            ],
            'midtransReady'   => $midtrans->isConfigured(),
        ]));
    }

    public function privacyPolicy(): string
    {
        return view('pages/privacy_policy', $this->pageData([
            'title'       => 'Kebijakan Privasi',
            'description' => 'Penjelasan cara Yayasan Bakti Mulya Masyarakat Mandiri mengelola data pengunjung, donatur, dan pengguna dashboard.',
            'sections'    => [
                [
                    'title'   => 'Data yang kami kumpulkan',
                    'content' => [
                        'Kami dapat mengumpulkan data identitas dasar seperti nama, email, nomor telepon, serta data transaksi donasi yang dikirimkan melalui website.',
                        'Data teknis seperti alamat IP, jenis browser, dan aktivitas dasar penggunaan website dapat tercatat untuk kebutuhan keamanan, audit, dan peningkatan layanan.',
                    ],
                ],
                [
                    'title'   => 'Tujuan penggunaan data',
                    'content' => [
                        'Data digunakan untuk mencatat donasi, memproses pembayaran melalui payment gateway resmi, menampilkan riwayat transaksi kepada pengguna, dan mendukung administrasi yayasan.',
                        'Kami juga dapat menggunakan data kontak untuk memberikan konfirmasi transaksi, pembaruan status donasi, atau informasi layanan yang relevan dengan aktivitas pengguna.',
                    ],
                ],
                [
                    'title'   => 'Perlindungan dan penyimpanan data',
                    'content' => [
                        'Kami berupaya menerapkan langkah teknis dan administratif yang wajar untuk melindungi data pengguna dari akses tanpa izin, perubahan, penyalahgunaan, atau kebocoran.',
                        'Akses ke data admin dan data pengguna dibatasi sesuai peran dan kebutuhan operasional yayasan.',
                    ],
                ],
                [
                    'title'   => 'Pembagian data kepada pihak ketiga',
                    'content' => [
                        'Kami tidak memperjualbelikan data pribadi pengguna. Data tertentu dapat diteruskan secara terbatas kepada penyedia layanan resmi seperti payment gateway untuk menyelesaikan proses transaksi.',
                        'Pihak ketiga yang terlibat hanya menerima data yang diperlukan untuk menjalankan layanan yang diminta pengguna.',
                    ],
                ],
                [
                    'title'   => 'Hak pengguna',
                    'content' => [
                        'Pengguna dapat meminta pembaruan data akun, koreksi informasi, atau penonaktifan akun sesuai kebijakan operasional yayasan dan ketentuan hukum yang berlaku.',
                        'Untuk pertanyaan terkait data pribadi, pengguna dapat menghubungi pengurus yayasan melalui kanal resmi yang tercantum di website.',
                    ],
                ],
            ],
        ]));
    }

    public function terms(): string
    {
        return view('pages/terms', $this->pageData([
            'title'       => 'Syarat dan Ketentuan',
            'description' => 'Ketentuan penggunaan website, layanan donasi, dan dashboard pengguna Yayasan Bakti Mulya Masyarakat Mandiri.',
            'sections'    => [
                [
                    'title'   => 'Penggunaan website',
                    'content' => [
                        'Website ini disediakan sebagai sarana informasi yayasan, publikasi program, dokumentasi kegiatan, dan penyaluran donasi secara digital.',
                        'Pengguna wajib menggunakan website secara sah, wajar, dan tidak melakukan tindakan yang merugikan sistem, yayasan, maupun pihak lain.',
                    ],
                ],
                [
                    'title'   => 'Akun pengguna',
                    'content' => [
                        'Pengguna yang membuat akun bertanggung jawab menjaga kerahasiaan kredensial login dan seluruh aktivitas yang terjadi pada akunnya.',
                        'Yayasan berhak menangguhkan atau menonaktifkan akun yang digunakan untuk pelanggaran, penyalahgunaan, atau aktivitas yang membahayakan sistem.',
                    ],
                ],
                [
                    'title'   => 'Ketentuan donasi',
                    'content' => [
                        'Donasi yang dilakukan melalui website akan diproses melalui payment gateway resmi atau mekanisme lain yang diumumkan oleh yayasan.',
                        'Pengguna wajib memastikan data donasi, nominal, dan program tujuan yang dipilih sudah sesuai sebelum menyelesaikan pembayaran.',
                    ],
                ],
                [
                    'title'   => 'Ketersediaan layanan',
                    'content' => [
                        'Yayasan berupaya menjaga website tetap tersedia, namun tidak menjamin bahwa layanan akan selalu bebas gangguan, keterlambatan, atau kesalahan teknis.',
                        'Perubahan fitur, konten, atau alur layanan dapat dilakukan sewaktu-waktu untuk kebutuhan operasional, keamanan, atau pengembangan sistem.',
                    ],
                ],
                [
                    'title'   => 'Batas tanggung jawab',
                    'content' => [
                        'Yayasan tidak bertanggung jawab atas kerugian yang timbul akibat kelalaian pengguna menjaga akun, penggunaan perangkat yang tidak aman, atau gangguan pihak ketiga di luar kendali wajar yayasan.',
                        'Dalam hal terjadi sengketa atau kendala transaksi, pengguna dianjurkan segera menghubungi pengurus melalui kanal resmi website.',
                    ],
                ],
            ],
        ]));
    }

    public function refundPolicy(): string
    {
        return view('pages/refund_policy', $this->pageData([
            'title'       => 'Kebijakan Pengembalian Dana',
            'description' => 'Informasi dasar mengenai kebijakan pengembalian dana untuk transaksi donasi yang diproses melalui website yayasan.',
            'sections'    => [
                [
                    'title'   => 'Prinsip umum',
                    'content' => [
                        'Donasi yang telah berhasil dibayarkan pada dasarnya bersifat sukarela dan ditujukan untuk mendukung program yayasan yang dipilih pengguna.',
                        'Yayasan akan meninjau permohonan pengembalian dana secara terbatas untuk kondisi tertentu yang dapat dibuktikan secara wajar.',
                    ],
                ],
                [
                    'title'   => 'Kondisi yang dapat dipertimbangkan',
                    'content' => [
                        'Transaksi ganda yang tidak disengaja, kesalahan nominal akibat gangguan sistem, atau pembayaran yang tercatat tidak sesuai dengan instruksi pengguna dapat diajukan untuk peninjauan.',
                        'Permohonan harus disampaikan secepat mungkin disertai bukti transaksi, identitas donatur, dan penjelasan singkat mengenai kendala yang terjadi.',
                    ],
                ],
                [
                    'title'   => 'Proses peninjauan',
                    'content' => [
                        'Setiap permohonan akan diverifikasi oleh pengurus yayasan berdasarkan data transaksi internal, catatan payment gateway, dan bukti pendukung dari pengguna.',
                        'Yayasan berhak meminta informasi tambahan sebelum memberikan keputusan akhir atas permohonan tersebut.',
                    ],
                ],
                [
                    'title'   => 'Cara menghubungi yayasan',
                    'content' => [
                        'Untuk pertanyaan mengenai kebijakan ini atau permohonan pengembalian dana, pengguna dapat menghubungi pengurus yayasan melalui email atau nomor resmi yang tercantum di website.',
                    ],
                ],
            ],
        ]));
    }

    public function submitDonation()
    {
        $rules = [
            'donor_name'      => 'required|min_length[3]|max_length[150]',
            'amount'          => 'required|decimal|greater_than[9999]',
            'payment_gateway' => 'required|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon lengkapi data donasi dengan benar.');
        }

        $programId = $this->request->getPost('program_id') ?: null;
        $donationModel = new DonationModel();
        $midtrans = new MidtransGateway();
        $user = auth_user();
        $selectedGateway = 'Midtrans Snap';
        $paymentChannel = 'snap_auto';
        $programTitle = 'Donasi Umum';

        if ($programId) {
            $program = (new ProgramModel())->find($programId);

            if (! $program) {
                return redirect()->back()->withInput()->with('error', 'Program donasi tidak ditemukan.');
            }

            if (($program['status'] ?? 'aktif') !== 'aktif') {
                return redirect()->back()->withInput()->with('error', 'Program ini sudah selesai dan tidak menerima donasi baru.');
            }

            $programTitle = $program['judul'] ?? $programTitle;
        }

        $orderId = 'YB3M-' . date('YmdHis') . '-' . random_int(1000, 9999);
        $transactionCode = 'DON-' . strtoupper(bin2hex(random_bytes(4)));

        $donationId = $donationModel->insert([
            'user_id'          => $user['id'] ?? null,
            'donor_name'       => $this->request->getPost('donor_name'),
            'donor_phone'      => $this->request->getPost('donor_phone'),
            'program_id'       => $programId,
            'amount'           => $this->request->getPost('amount'),
            'payment_method'   => $paymentChannel,
            'provider'         => 'midtrans',
            'order_id'         => $orderId,
            'payment_gateway'  => $selectedGateway,
            'payment_channel'  => $paymentChannel,
            'payment_status'   => 'pending',
            'provider_status'  => 'pending',
            'transaction_code' => $transactionCode,
            'message'          => $this->request->getPost('message'),
        ], true);

        if (! $midtrans->isConfigured()) {
            return redirect()->to(site_url('donasi'))->with('error', 'Midtrans belum dikonfigurasi. Isi server key dan client key terlebih dahulu.');
        }

        try {
            $transaction = $midtrans->createTransaction([
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => (int) $this->request->getPost('amount'),
                ],
                'item_details' => [[
                    'id'       => (string) ($programId ?: 'general'),
                    'price'    => (int) $this->request->getPost('amount'),
                    'quantity' => 1,
                    'name'     => $programTitle,
                ]],
                'customer_details' => [
                    'first_name' => $this->request->getPost('donor_name'),
                    'email'      => $user['email'] ?? ('guest+' . $orderId . '@yb3m.local'),
                    'phone'      => $this->request->getPost('donor_phone'),
                ],
                'callbacks' => [
                    'finish' => site_url('payment/finish'),
                ],
            ]);
        } catch (\Throwable $exception) {
            return redirect()->to(site_url('donasi'))->with('error', 'Gagal membuat transaksi Midtrans: ' . $exception->getMessage());
        }

        $donationModel->update($donationId, [
            'snap_token'  => $transaction->token ?? null,
            'payment_url' => $transaction->redirect_url ?? null,
        ]);

        if (! empty($transaction->redirect_url)) {
            return redirect()->to($transaction->redirect_url);
        }

        return redirect()->to(site_url('donasi'))->with('success', 'Donasi berhasil dicatat. Silakan lanjutkan pembayaran melalui Midtrans Snap.');
    }

    private function pageData(array $data = []): array
    {
        return array_merge([
            'site'       => $this->site,
            'currentUri' => service('request')->getUri()->getPath(),
            'authUser'   => auth_user(),
        ], $data);
    }

    private function decorateProgram(array $program, array $paidMap = []): array
    {
        $programId = (int) $program['id'];
        $paidStats = $paidMap[$programId] ?? [];
        $raised = (float) ($paidStats['total_amount'] ?? $program['terkumpul']);
        $target = max((float) $program['target_dana'], 1);
        $donorCount = (int) ($paidStats['donor_count'] ?? 0);

        $program['terkumpul'] = $raised;
        $program['donor_count'] = $donorCount;
        $program['progress_percent'] = min(100, (int) round(($raised / $target) * 100));
        $program['days_label'] = $program['status'] === 'selesai' ? 'Program Selesai' : 'Donasi Dibuka';
        $program['donation_label'] = $donorCount > 0 ? $donorCount . ' donatur' : 'Menunggu donasi pertama';

        return $program;
    }
}
