<?php

namespace App\Controllers;

use App\Libraries\DonationStats;
use App\Libraries\MidtransGateway;
use App\Models\DonationModel;
use App\Models\GalleryModel;
use App\Models\ProgramModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    private const PROGRAM_UPLOAD_DIR = 'assets/images/uploads/programs';
    private const GALLERY_UPLOAD_DIR = 'assets/images/uploads/galleries';

    public function user(): string
    {
        $user = auth_user();
        $userRecord = (new UserModel())->find($user['id']);
        $donations = (new DonationModel())
            ->where('user_id', $user['id'])
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('dashboard/user', $this->basePageData([
            'title'       => 'Dashboard User',
            'description' => 'Pantau riwayat donasi Anda.',
            'authUser'    => $user,
            'userRecord'  => $userRecord,
            'donations'   => $donations,
        ]));
    }

    public function admin(): string
    {
        return $this->renderAdminPage();
    }

    public function editProgram(int $id): string
    {
        return $this->renderAdminPage([
            'editingProgram' => (new ProgramModel())->find($id),
        ]);
    }

    public function saveProgram()
    {
        $rules = [
            'judul'       => 'required|min_length[5]|max_length[180]',
            'deskripsi'   => 'required|min_length[20]',
            'target_dana' => 'required|decimal|greater_than[0]',
            'status'      => 'required|in_list[aktif,selesai]',
            'gambar_file' => 'uploaded[gambar_file]|is_image[gambar_file]|mime_in[gambar_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar_file,4096]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data program belum lengkap atau belum valid.');
        }

        $slug = $this->buildUniqueSlug(
            new ProgramModel(),
            (string) $this->request->getPost('slug'),
            (string) $this->request->getPost('judul')
        );
        try {
            $imagePath = $this->storeUploadedImage('gambar_file', self::PROGRAM_UPLOAD_DIR);
        } catch (\RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        (new ProgramModel())->insert([
            'judul'       => $this->request->getPost('judul'),
            'slug'        => $slug,
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'target_dana' => $this->request->getPost('target_dana'),
            'gambar'      => $imagePath,
            'status'      => $this->request->getPost('status'),
            'terkumpul'   => 0,
        ]);

        return redirect()->to(site_url('admin'))->with('success', 'Program baru berhasil ditambahkan.');
    }

    public function updateProgram(int $id)
    {
        $programModel = new ProgramModel();
        $program = $programModel->find($id);

        if (! $program) {
            return redirect()->to(site_url('admin'))->with('error', 'Program tidak ditemukan.');
        }

        $rules = [
            'judul'       => 'required|min_length[5]|max_length[180]',
            'deskripsi'   => 'required|min_length[20]',
            'target_dana' => 'required|decimal|greater_than[0]',
            'status'      => 'required|in_list[aktif,selesai]',
        ];

        $programFile = $this->request->getFile('gambar_file');
        if ($programFile && $programFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['gambar_file'] = 'is_image[gambar_file]|mime_in[gambar_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar_file,4096]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Perubahan program belum valid.');
        }

        $slug = $this->buildUniqueSlug(
            $programModel,
            (string) $this->request->getPost('slug'),
            (string) $this->request->getPost('judul'),
            $id
        );
        try {
            $imagePath = $this->storeUploadedImage('gambar_file', self::PROGRAM_UPLOAD_DIR, $program['gambar'] ?? null);
        } catch (\RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $programModel->update($id, [
            'judul'       => $this->request->getPost('judul'),
            'slug'        => $slug,
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'target_dana' => $this->request->getPost('target_dana'),
            'gambar'      => $imagePath,
            'status'      => $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('admin'))->with('success', 'Program berhasil diperbarui.');
    }

    public function deleteProgram(int $id)
    {
        $programModel = new ProgramModel();
        $program = $programModel->find($id);

        if (! $program) {
            return redirect()->to(site_url('admin'))->with('error', 'Program tidak ditemukan.');
        }

        $donationCount = (new DonationModel())->where('program_id', $id)->countAllResults();
        if ($donationCount > 0) {
            return redirect()->to(site_url('admin'))->with('error', 'Program tidak bisa dihapus karena sudah memiliki riwayat donasi.');
        }

        $programModel->delete($id);

        return redirect()->to(site_url('admin'))->with('success', 'Program berhasil dihapus.');
    }

    public function editGallery(int $id): string
    {
        return $this->renderAdminPage([
            'editingGallery' => (new GalleryModel())->find($id),
        ]);
    }

    public function saveGallery()
    {
        $rules = [
            'title'      => 'required|min_length[3]|max_length[180]',
            'caption'    => 'required|min_length[10]',
            'category'   => 'required|in_list[home,gallery]',
            'image_file' => 'uploaded[image_file]|is_image[image_file]|mime_in[image_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[image_file,4096]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data galeri belum lengkap atau belum valid.');
        }

        $slug = $this->buildUniqueSlug(
            new GalleryModel(),
            (string) $this->request->getPost('slug'),
            (string) $this->request->getPost('title')
        );
        try {
            $imagePath = $this->storeUploadedImage('image_file', self::GALLERY_UPLOAD_DIR);
        } catch (\RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        (new GalleryModel())->insert([
            'title'        => $this->request->getPost('title'),
            'slug'         => $slug,
            'image'        => $imagePath,
            'caption'      => $this->request->getPost('caption'),
            'category'     => $this->request->getPost('category'),
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
        ]);

        return redirect()->to(site_url('admin'))->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function updateGallery(int $id)
    {
        $galleryModel = new GalleryModel();
        $gallery = $galleryModel->find($id);

        if (! $gallery) {
            return redirect()->to(site_url('admin'))->with('error', 'Galeri tidak ditemukan.');
        }

        $rules = [
            'title'      => 'required|min_length[3]|max_length[180]',
            'caption'    => 'required|min_length[10]',
            'category'   => 'required|in_list[home,gallery]',
        ];

        $galleryFile = $this->request->getFile('image_file');
        if ($galleryFile && $galleryFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image_file'] = 'is_image[image_file]|mime_in[image_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[image_file,4096]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Perubahan galeri belum valid.');
        }

        $slug = $this->buildUniqueSlug(
            $galleryModel,
            (string) $this->request->getPost('slug'),
            (string) $this->request->getPost('title'),
            $id
        );
        try {
            $imagePath = $this->storeUploadedImage('image_file', self::GALLERY_UPLOAD_DIR, $gallery['image'] ?? null);
        } catch (\RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $galleryModel->update($id, [
            'title'        => $this->request->getPost('title'),
            'slug'         => $slug,
            'image'        => $imagePath,
            'caption'      => $this->request->getPost('caption'),
            'category'     => $this->request->getPost('category'),
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
        ]);

        return redirect()->to(site_url('admin'))->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function deleteGallery(int $id)
    {
        $galleryModel = new GalleryModel();
        $gallery = $galleryModel->find($id);

        if (! $gallery) {
            return redirect()->to(site_url('admin'))->with('error', 'Galeri tidak ditemukan.');
        }

        $galleryModel->delete($id);

        return redirect()->to(site_url('admin'))->with('success', 'Item galeri berhasil dihapus.');
    }

    public function editUser(int $id): string
    {
        return $this->renderAdminPage([
            'editingUser' => (new UserModel())->find($id),
        ]);
    }

    public function saveUser()
    {
        $rules = [
            'name'      => 'required|min_length[3]|max_length[150]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]',
            'role'      => 'required|in_list[admin,user]',
            'is_active' => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data user belum lengkap atau belum valid.');
        }

        (new UserModel())->insert([
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $this->request->getPost('role'),
            'is_active'     => (int) $this->request->getPost('is_active'),
        ]);

        return redirect()->to(site_url('admin'))->with('success', 'User baru berhasil ditambahkan.');
    }

    public function updateUser(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (! $user) {
            return redirect()->to(site_url('admin'))->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'name'      => 'required|min_length[3]|max_length[150]',
            'email'     => 'required|valid_email',
            'role'      => 'required|in_list[admin,user]',
            'is_active' => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Perubahan user belum valid.');
        }

        $email = (string) $this->request->getPost('email');
        $emailOwner = $userModel->where('email', $email)->first();
        if ($emailOwner && (int) $emailOwner['id'] !== $id) {
            return redirect()->back()->withInput()->with('error', 'Email sudah dipakai user lain.');
        }

        $payload = [
            'name'      => $this->request->getPost('name'),
            'email'     => $email,
            'phone'     => $this->request->getPost('phone'),
            'role'      => $this->request->getPost('role'),
            'is_active' => (int) $this->request->getPost('is_active'),
        ];

        $password = trim((string) $this->request->getPost('password'));
        if ($password !== '') {
            if (strlen($password) < 8) {
                return redirect()->back()->withInput()->with('error', 'Password baru minimal 8 karakter.');
            }

            $payload['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $payload);

        return redirect()->to(site_url('admin'))->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (! $user) {
            return redirect()->to(site_url('admin'))->with('error', 'User tidak ditemukan.');
        }

        if ((int) $user['id'] === (int) (auth_user()['id'] ?? 0)) {
            return redirect()->to(site_url('admin'))->with('error', 'Akun admin yang sedang dipakai tidak bisa dihapus.');
        }

        $donationCount = (new DonationModel())->where('user_id', $id)->countAllResults();
        if ($donationCount > 0) {
            return redirect()->to(site_url('admin'))->with('error', 'User tidak bisa dihapus karena sudah punya riwayat donasi.');
        }

        $userModel->delete($id);

        return redirect()->to(site_url('admin'))->with('success', 'User berhasil dihapus.');
    }

    public function updateDonationStatus(int $id)
    {
        $status = $this->request->getPost('payment_status');
        $allowed = ['pending', 'paid', 'failed'];

        if (! in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid.');
        }

        $donationModel = new DonationModel();
        $donation = $donationModel->find($id);

        if (! $donation) {
            return redirect()->back()->with('error', 'Data donasi tidak ditemukan.');
        }

        $donationModel->update($id, [
            'payment_status' => $status,
            'provider_status'=> $status,
            'paid_at'        => $status === 'paid' ? date('Y-m-d H:i:s') : null,
        ]);

        (new DonationStats())->syncProgramTotal((int) ($donation['program_id'] ?? 0));

        return redirect()->to(site_url('admin'))->with('success', 'Status donasi berhasil diperbarui.');
    }

    public function updateOwnAccount()
    {
        $authUser = auth_user();
        $userModel = new UserModel();
        $user = $userModel->find($authUser['id'] ?? 0);

        if (! $user) {
            return redirect()->to(site_url('login'))->with('error', 'Sesi akun tidak ditemukan. Silakan login kembali.');
        }

        $rules = [
            'name'             => 'required|min_length[3]|max_length[150]',
            'email'            => 'required|valid_email',
            'current_password' => 'required|min_length[8]',
        ];

        $newPassword = trim((string) $this->request->getPost('new_password'));
        $confirmPassword = trim((string) $this->request->getPost('confirm_password'));

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data akun belum lengkap atau belum valid.');
        }

        if (! password_verify((string) $this->request->getPost('current_password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Password saat ini tidak sesuai.');
        }

        if ($newPassword !== '' || $confirmPassword !== '') {
            if (strlen($newPassword) < 8) {
                return redirect()->back()->withInput()->with('error', 'Password baru minimal 8 karakter.');
            }

            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->withInput()->with('error', 'Konfirmasi password baru belum sama.');
            }
        }

        $email = (string) $this->request->getPost('email');
        $emailOwner = $userModel->where('email', $email)->first();
        if ($emailOwner && (int) $emailOwner['id'] !== (int) $user['id']) {
            return redirect()->back()->withInput()->with('error', 'Email tersebut sudah digunakan akun lain.');
        }

        $payload = [
            'name'  => $this->request->getPost('name'),
            'email' => $email,
            'phone' => $this->request->getPost('phone'),
        ];

        if ($newPassword !== '') {
            $payload['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $userModel->update($user['id'], $payload);

        $updated = $userModel->find($user['id']);
        $this->syncAuthSession($updated);

        $redirectTo = ($updated['role'] ?? 'user') === 'admin' ? site_url('admin') : site_url('dashboard');

        return redirect()->to($redirectTo)->with('success', 'Akun berhasil diperbarui. Gunakan email dan password baru Anda mulai sekarang.');
    }

    private function renderAdminPage(array $overrides = []): string
    {
        $donationModel = new DonationModel();
        $programModel = new ProgramModel();
        $galleryModel = new GalleryModel();
        $userModel = new UserModel();
        $authUser = auth_user();
        $adminProfile = $userModel->find($authUser['id'] ?? 0);
        $programs = $programModel->orderBy('id', 'DESC')->findAll();
        $paidTotals = $donationModel
            ->selectSum('amount')
            ->where('payment_status', 'paid')
            ->first();
        $midtrans = new MidtransGateway();
        $programIndex = [];

        foreach ($programs as $program) {
            $programIndex[(int) $program['id']] = $program['judul'];
        }

        return view('dashboard/admin', $this->basePageData(array_merge([
            'title'          => 'Dashboard Admin',
            'description'    => 'Kelola donasi, user, program, galeri, dan pengaturan operasional yayasan.',
            'authUser'       => $authUser,
            'adminProfile'   => $adminProfile,
            'donationCount'  => $donationModel->countAllResults(),
            'totalRaised'    => $paidTotals['amount'] ?? 0,
            'userCount'      => $userModel->countAllResults(),
            'programCount'   => $programModel->countAllResults(),
            'galleryCount'   => $galleryModel->countAllResults(),
            'donations'      => $donationModel->orderBy('id', 'DESC')->findAll(20),
            'programs'       => $programs,
            'programIndex'   => $programIndex,
            'galleries'      => $galleryModel->orderBy('id', 'DESC')->findAll(),
            'users'          => $userModel->orderBy('id', 'DESC')->findAll(),
            'editingProgram' => null,
            'editingGallery' => null,
            'editingUser'    => null,
            'midtransReady'  => $midtrans->isConfigured(),
            'midtransMode'   => $midtrans->isProduction() ? 'Production' : 'Sandbox',
            'midtransClient' => $midtrans->clientKey(),
            'midtransMerchant' => $midtrans->merchantId(),
        ], $overrides)));
    }

    private function syncAuthSession(array $user): void
    {
        session()->set('auth_user', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ]);
    }

    private function buildUniqueSlug(object $model, string $submittedSlug, string $fallbackTitle, ?int $ignoreId = null): string
    {
        $baseSlug = url_title($submittedSlug !== '' ? $submittedSlug : $fallbackTitle, '-', true);
        $slug = $baseSlug !== '' ? $baseSlug : 'item';
        $counter = 1;

        while (true) {
            $existing = $model->where('slug', $slug)->first();

            if (! $existing || ($ignoreId !== null && (int) $existing['id'] === $ignoreId)) {
                return $slug;
            }

            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }
    }

    private function storeUploadedImage(string $fieldName, string $relativeDirectory, ?string $existingPath = null): string
    {
        $file = $this->request->getFile($fieldName);

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $targetDirectory = rtrim(FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $relativeDirectory), DIRECTORY_SEPARATOR);

            if (! is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($targetDirectory, $newName);

            return trim($relativeDirectory, '/') . '/' . $newName;
        }

        if ($existingPath) {
            return $existingPath;
        }

        throw new \RuntimeException('File gambar belum dipilih atau gagal diunggah.');
    }
}
