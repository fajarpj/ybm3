<?php

namespace App\Controllers;

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
        'bankAccounts' => [
            ['bank' => 'BRI', 'number' => '6877-01-008170-53-3'],
            ['bank' => 'Mandiri', 'number' => '138-00-1874846-2'],
        ],
        'bankHolder'   => 'Yayasan Bakti Mulya Masyarakat Mandiri',
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

        return view('pages/home', $this->pageData([
            'title'          => 'Beranda',
            'description'    => 'Website resmi Yayasan Bakti Mulya Masyarakat Mandiri untuk profil yayasan, galeri kegiatan, dan donasi digital.',
            'bismillah'      => 'بِسْــــــــــــــمِ اللهِ الرَّحْمَنِ الرَّحِيْـــــم',
            'greeting'       => 'السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُه.',
            'closing'        => 'وَالسَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُه.',
            'verse'          => 'Dan apabila hamba-hamba-Ku bertanya kepadamu (Muhammad) tentang Aku, maka sesungguhnya Aku dekat. Aku kabulkan permohonan orang yang berdoa apabila dia berdoa kepada-Ku. Hendaklah mereka itu memenuhi (perintah)-Ku dan beriman kepada-Ku, agar mereka memperoleh kebenaran. (QS. Al-Baqarah: 186)',
            'heroSlides'     => $galleryModel->where('is_published', 1)->where('category', 'home')->orderBy('id', 'ASC')->findAll(),
            'highlights'     => [
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
            'quickPrograms'  => [
                'Program santunan untuk masyarakat yang membutuhkan.',
                'Kegiatan pembinaan, pendidikan, dan nilai-nilai keislaman.',
                'Program kemandirian untuk memperkuat kebermanfaatan jangka panjang.',
            ],
            'trustPoints'    => [
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
            'missions'    => [
                'Menghadirkan program sosial yang menyentuh kebutuhan masyarakat secara langsung.',
                'Menguatkan pembinaan dan pendidikan sebagai fondasi perubahan yang baik.',
                'Mengembangkan sistem digital yayasan agar pengelolaan program dan donasi semakin tertib.',
            ],
        ]));
    }

    public function programs(): string
    {
        $programModel = new ProgramModel();

        return view('pages/programs', $this->pageData([
            'title'       => 'Program',
            'description' => 'Ringkasan program utama Yayasan Bakti Mulya Masyarakat Mandiri yang dapat terus dikembangkan seiring perjalanan yayasan.',
            'programs'    => $programModel->orderBy('id', 'DESC')->findAll(),
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

        return view('pages/donation', $this->pageData([
            'title'           => 'Donasi',
            'description'     => 'Salurkan donasi terbaik Anda untuk mendukung program Yayasan Bakti Mulya Masyarakat Mandiri.',
            'programOptions'  => $programModel->where('status', 'aktif')->orderBy('id', 'DESC')->findAll(),
            'donationSteps'   => [
                'Login atau daftar agar donasi otomatis tercatat di dashboard user.',
                'Pilih nominal dan program, lalu lanjutkan pembayaran melalui Midtrans atau transfer manual.',
                'Admin dapat memantau status transaksi dari dashboard secara langsung.',
            ],
            'paymentChannels' => [
                'Midtrans Snap untuk pembayaran legal dan siap produksi.',
                'Manual transfer ke rekening yayasan sebagai cadangan operasional.',
                'Status pembayaran dapat diperbarui lewat notifikasi gateway dan dashboard admin.',
            ],
            'gatewayOptions'  => ['Midtrans', 'Manual Transfer'],
            'channelOptions'  => ['Bank Transfer', 'QRIS', 'Virtual Account', 'E-Wallet'],
            'midtransReady'   => $midtrans->isConfigured(),
        ]));
    }

    public function submitDonation()
    {
        $rules = [
            'donor_name'      => 'required|min_length[3]|max_length[150]',
            'amount'          => 'required|decimal|greater_than[9999]',
            'payment_gateway' => 'required|max_length[50]',
            'payment_channel' => 'required|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon lengkapi data donasi dengan benar.');
        }

        $programId = $this->request->getPost('program_id') ?: null;
        $donationModel = new DonationModel();
        $midtrans = new MidtransGateway();
        $user = auth_user();

        $orderId = 'YB3M-' . date('YmdHis') . '-' . random_int(1000, 9999);
        $transactionCode = 'DON-' . strtoupper(bin2hex(random_bytes(4)));

        $donationId = $donationModel->insert([
            'user_id'         => $user['id'] ?? null,
            'donor_name'      => $this->request->getPost('donor_name'),
            'donor_phone'     => $this->request->getPost('donor_phone'),
            'program_id'      => $programId,
            'amount'          => $this->request->getPost('amount'),
            'payment_method'  => $this->request->getPost('payment_channel'),
            'provider'        => strtolower($this->request->getPost('payment_gateway')) === 'midtrans' ? 'midtrans' : 'manual',
            'order_id'        => $orderId,
            'payment_gateway' => $this->request->getPost('payment_gateway'),
            'payment_channel' => $this->request->getPost('payment_channel'),
            'payment_status'  => 'pending',
            'provider_status' => 'pending',
            'transaction_code'=> $transactionCode,
            'message'         => $this->request->getPost('message'),
        ], true);

        if (strtolower((string) $this->request->getPost('payment_gateway')) === 'midtrans') {
            if (! $midtrans->isConfigured()) {
                return redirect()->to(site_url('donasi'))->with('error', 'Midtrans belum dikonfigurasi. Isi server key dan client key terlebih dahulu.');
            }

            $programTitle = 'Donasi Umum';
            if ($programId) {
                $program = (new ProgramModel())->find($programId);
                $programTitle = $program['judul'] ?? $programTitle;
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
                'snap_token' => $transaction->token ?? null,
                'payment_url'=> $transaction->redirect_url ?? null,
            ]);

            if (! empty($transaction->redirect_url)) {
                return redirect()->to($transaction->redirect_url);
            }
        }

        return redirect()->to(site_url('donasi'))->with('success', 'Donasi berhasil dicatat. Silakan lanjutkan pembayaran sesuai metode yang dipilih.');
    }

    private function pageData(array $data = []): array
    {
        return array_merge([
            'site'        => $this->site,
            'currentUri'  => service('request')->getUri()->getPath(),
            'authUser'    => auth_user(),
        ], $data);
    }
}
