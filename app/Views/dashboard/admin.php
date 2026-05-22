<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Dashboard Admin</p>
        <h1>Kontrol operasional website yayasan</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="stats-grid">
            <article class="info-card"><p class="panel__label">Total Donasi</p><h3><?= esc((string) $donationCount) ?></h3></article>
            <article class="info-card"><p class="panel__label">Dana Terkonfirmasi</p><h3>Rp<?= number_format((float) $totalRaised, 0, ',', '.') ?></h3></article>
            <article class="info-card"><p class="panel__label">User</p><h3><?= esc((string) $userCount) ?></h3></article>
            <article class="info-card"><p class="panel__label">Program</p><h3><?= esc((string) $programCount) ?></h3></article>
            <article class="info-card"><p class="panel__label">Galeri</p><h3><?= esc((string) $galleryCount) ?></h3></article>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container admin-stack">
        <article class="panel">
            <p class="panel__label">Midtrans Testing</p>
            <h2>Konfigurasi payment gateway</h2>
            <div class="admin-config-grid">
                <div class="info-card">
                    <p class="panel__label">Mode</p>
                    <h3><?= esc($midtransMode) ?></h3>
                    <p><?= $midtransReady ? 'Sandbox key sudah terbaca dari environment dan siap untuk testing transaksi.' : 'Key Midtrans belum lengkap di environment.' ?></p>
                </div>
                <div class="info-card">
                    <p class="panel__label">Merchant ID</p>
                    <h3><?= esc($midtransMerchant !== '' ? $midtransMerchant : '-') ?></h3>
                    <p>Gunakan mode sandbox sampai akun Midtrans production disetujui.</p>
                </div>
                <div class="info-card">
                    <p class="panel__label">Client Key</p>
                    <h3><?= esc($midtransClient !== '' ? substr($midtransClient, 0, 18) . '...' : '-') ?></h3>
                    <p>Callback notifikasi tetap diarahkan ke endpoint website saat testing.</p>
                </div>
            </div>
        </article>

        <article class="panel account-panel">
            <p class="panel__label">Akun Admin</p>
            <h2>Ganti email resmi dan password admin</h2>
            <form class="donation-form" action="<?= site_url('admin/account') ?>" method="post">
                <?= csrf_field() ?>
                <label class="form-field">
                    <span>Nama admin</span>
                    <input type="text" name="name" value="<?= esc(old('name', $adminProfile['name'] ?? $authUser['name'])) ?>" placeholder="Nama admin">
                </label>
                <label class="form-field">
                    <span>Email admin</span>
                    <input type="email" name="email" value="<?= esc(old('email', $adminProfile['email'] ?? $authUser['email'])) ?>" placeholder="admin@domain.com">
                </label>
                <label class="form-field">
                    <span>No. HP</span>
                    <input type="text" name="phone" value="<?= esc(old('phone', $adminProfile['phone'] ?? '')) ?>" placeholder="08xxxxxxxxxx">
                </label>
                <label class="form-field">
                    <span>Password saat ini</span>
                    <input type="password" name="current_password" value="" placeholder="Wajib untuk verifikasi perubahan">
                </label>
                <label class="form-field">
                    <span>Password baru</span>
                    <input type="password" name="new_password" value="" placeholder="Kosongkan jika tidak diganti">
                </label>
                <label class="form-field">
                    <span>Konfirmasi password baru</span>
                    <input type="password" name="confirm_password" value="" placeholder="Ulangi password baru">
                </label>
                <div class="admin-form-actions form-field--full">
                    <button class="button button--primary" type="submit">Simpan Perubahan Admin</button>
                </div>
            </form>
        </article>

        <div class="admin-split">
            <article class="panel">
                <p class="panel__label"><?= $editingProgram ? 'Edit Program' : 'Tambah Program' ?></p>
                <h2><?= $editingProgram ? 'Perbarui campaign yayasan' : 'Buat program donasi baru' ?></h2>
                <form class="donation-form" action="<?= $editingProgram ? site_url('admin/programs/' . $editingProgram['id']) : site_url('admin/programs') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <label class="form-field">
                        <span>Judul program</span>
                        <input type="text" name="judul" value="<?= esc(old('judul', $editingProgram['judul'] ?? '')) ?>" placeholder="Santunan dhuafa dan yatim">
                    </label>
                    <label class="form-field">
                        <span>Slug</span>
                        <input type="text" name="slug" value="<?= esc(old('slug', $editingProgram['slug'] ?? '')) ?>" placeholder="otomatis-dari-judul">
                    </label>
                    <label class="form-field form-field--full">
                        <span>Deskripsi</span>
                        <textarea name="deskripsi" rows="4" placeholder="Jelaskan manfaat dan fokus program"><?= esc(old('deskripsi', $editingProgram['deskripsi'] ?? '')) ?></textarea>
                    </label>
                    <label class="form-field">
                        <span>Target dana</span>
                        <input type="number" name="target_dana" min="1000" step="1000" value="<?= esc(old('target_dana', $editingProgram['target_dana'] ?? '')) ?>" placeholder="100000000">
                    </label>
                    <label class="form-field">
                        <span>Status</span>
                        <select name="status">
                            <?php $programStatus = old('status', $editingProgram['status'] ?? 'aktif'); ?>
                            <?php foreach (['aktif', 'selesai'] as $status): ?>
                                <option value="<?= $status ?>" <?= $programStatus === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="form-field form-field--full">
                        <span>Upload gambar program</span>
                        <input type="file" name="gambar_file" accept=".jpg,.jpeg,.png,.webp">
                    </label>
                    <?php if (! empty($editingProgram['gambar'])): ?>
                        <div class="admin-upload-note form-field--full">
                            <strong>Gambar saat ini</strong>
                            <p><?= esc($editingProgram['gambar']) ?></p>
                            <img src="<?= base_url($editingProgram['gambar']) ?>" alt="<?= esc($editingProgram['judul']) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="admin-form-actions form-field--full">
                        <button class="button button--primary" type="submit"><?= $editingProgram ? 'Simpan Perubahan Program' : 'Tambah Program' ?></button>
                        <?php if ($editingProgram): ?>
                            <a class="button button--ghost" href="<?= site_url('admin') ?>">Batal Edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </article>

            <article class="panel">
                <p class="panel__label"><?= $editingGallery ? 'Edit Galeri' : 'Tambah Galeri' ?></p>
                <h2><?= $editingGallery ? 'Perbarui dokumentasi visual' : 'Tambah dokumentasi baru' ?></h2>
                <form class="donation-form" action="<?= $editingGallery ? site_url('admin/galleries/' . $editingGallery['id']) : site_url('admin/galleries') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <label class="form-field">
                        <span>Judul</span>
                        <input type="text" name="title" value="<?= esc(old('title', $editingGallery['title'] ?? '')) ?>" placeholder="Kegiatan santunan bulan ini">
                    </label>
                    <label class="form-field">
                        <span>Slug</span>
                        <input type="text" name="slug" value="<?= esc(old('slug', $editingGallery['slug'] ?? '')) ?>" placeholder="otomatis-dari-judul">
                    </label>
                    <label class="form-field form-field--full">
                        <span>Caption</span>
                        <textarea name="caption" rows="4" placeholder="Penjelasan singkat dokumentasi"><?= esc(old('caption', $editingGallery['caption'] ?? '')) ?></textarea>
                    </label>
                    <label class="form-field">
                        <span>Kategori</span>
                        <?php $galleryCategory = old('category', $editingGallery['category'] ?? 'gallery'); ?>
                        <select name="category">
                            <?php foreach (['home', 'gallery'] as $category): ?>
                                <option value="<?= $category ?>" <?= $galleryCategory === $category ? 'selected' : '' ?>><?= ucfirst($category) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="form-field">
                        <span>Publikasi</span>
                        <?php $galleryPublished = (string) old('is_published', (string) ($editingGallery['is_published'] ?? '1')); ?>
                        <select name="is_published">
                            <option value="1" <?= $galleryPublished === '1' ? 'selected' : '' ?>>Tayang</option>
                            <option value="0" <?= $galleryPublished === '0' ? 'selected' : '' ?>>Sembunyikan</option>
                        </select>
                    </label>
                    <label class="form-field form-field--full">
                        <span>Upload gambar galeri</span>
                        <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp">
                    </label>
                    <?php if (! empty($editingGallery['image'])): ?>
                        <div class="admin-upload-note form-field--full">
                            <strong>Gambar saat ini</strong>
                            <p><?= esc($editingGallery['image']) ?></p>
                            <img src="<?= base_url($editingGallery['image']) ?>" alt="<?= esc($editingGallery['title']) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="admin-form-actions form-field--full">
                        <button class="button button--primary" type="submit"><?= $editingGallery ? 'Simpan Perubahan Galeri' : 'Tambah Galeri' ?></button>
                        <?php if ($editingGallery): ?>
                            <a class="button button--ghost" href="<?= site_url('admin') ?>">Batal Edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </article>
        </div>

        <article class="panel">
            <p class="panel__label"><?= $editingUser ? 'Edit User' : 'Tambah User' ?></p>
            <h2><?= $editingUser ? 'Perbarui akun admin atau user' : 'Buat akun baru dari dashboard admin' ?></h2>
            <form class="donation-form" action="<?= $editingUser ? site_url('admin/users/' . $editingUser['id']) : site_url('admin/users') ?>" method="post">
                <?= csrf_field() ?>
                <label class="form-field">
                    <span>Nama</span>
                    <input type="text" name="name" value="<?= esc(old('name', $editingUser['name'] ?? '')) ?>" placeholder="Nama lengkap">
                </label>
                <label class="form-field">
                    <span>Email</span>
                    <input type="email" name="email" value="<?= esc(old('email', $editingUser['email'] ?? '')) ?>" placeholder="email@domain.com">
                </label>
                <label class="form-field">
                    <span>No. HP</span>
                    <input type="text" name="phone" value="<?= esc(old('phone', $editingUser['phone'] ?? '')) ?>" placeholder="08xxxxxxxxxx">
                </label>
                <label class="form-field">
                    <span>Password <?= $editingUser ? '(isi jika ingin ganti)' : '' ?></span>
                    <input type="password" name="password" value="" placeholder="<?= $editingUser ? 'Kosongkan jika tidak diganti' : 'Minimal 8 karakter' ?>">
                </label>
                <label class="form-field">
                    <span>Role</span>
                    <?php $userRole = old('role', $editingUser['role'] ?? 'user'); ?>
                    <select name="role">
                        <?php foreach (['admin', 'user'] as $role): ?>
                            <option value="<?= $role ?>" <?= $userRole === $role ? 'selected' : '' ?>><?= ucfirst($role) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="form-field">
                    <span>Status akun</span>
                    <?php $userActive = (string) old('is_active', (string) ($editingUser['is_active'] ?? '1')); ?>
                    <select name="is_active">
                        <option value="1" <?= $userActive === '1' ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $userActive === '0' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </label>
                <div class="admin-form-actions form-field--full">
                    <button class="button button--primary" type="submit"><?= $editingUser ? 'Simpan Perubahan User' : 'Tambah User' ?></button>
                    <?php if ($editingUser): ?>
                        <a class="button button--ghost" href="<?= site_url('admin') ?>">Batal Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </article>

        <article class="panel">
            <p class="panel__label">Manajemen Donasi</p>
            <h2>Status transaksi dan pembayaran</h2>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Donatur</th>
                            <th>Program</th>
                            <th>Nominal</th>
                            <th>Gateway</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $donation): ?>
                            <tr>
                                <td><?= esc($donation['order_id'] ?? '-') ?></td>
                                <td><?= esc($donation['donor_name']) ?></td>
                                <td><?= esc($donation['program_id'] ? ($programIndex[(int) $donation['program_id']] ?? 'Program #' . $donation['program_id']) : 'Umum') ?></td>
                                <td>Rp<?= number_format((float) $donation['amount'], 0, ',', '.') ?></td>
                                <td><?= esc($donation['payment_gateway']) ?></td>
                                <td><?= esc($donation['payment_status']) ?></td>
                                <td>
                                    <form class="inline-form" action="<?= site_url('admin/donations/' . $donation['id'] . '/status') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <select name="payment_status">
                                            <?php foreach (['pending', 'paid', 'failed'] as $status): ?>
                                                <option value="<?= $status ?>" <?= $donation['payment_status'] === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="button button--ghost" type="submit">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>

        <div class="admin-split">
            <article class="panel">
                <p class="panel__label">Daftar Program</p>
                <h2>Semua campaign aktif dan selesai</h2>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Target</th>
                                <th>Terkumpul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($programs as $program): ?>
                                <tr>
                                    <td><?= esc($program['judul']) ?></td>
                                    <td>Rp<?= number_format((float) $program['target_dana'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format((float) $program['terkumpul'], 0, ',', '.') ?></td>
                                    <td><?= esc($program['status']) ?></td>
                                    <td class="admin-table-actions">
                                        <a class="button button--ghost button--small" href="<?= site_url('admin/programs/' . $program['id'] . '/edit') ?>">Edit</a>
                                        <form action="<?= site_url('admin/programs/' . $program['id'] . '/delete') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button class="button button--ghost button--small button--danger" type="submit">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="panel">
                <p class="panel__label">Daftar Galeri</p>
                <h2>Dokumentasi slider dan halaman galeri</h2>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tayang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($galleries as $gallery): ?>
                                <tr>
                                    <td><?= esc($gallery['title']) ?></td>
                                    <td><?= esc($gallery['category']) ?></td>
                                    <td><?= (int) $gallery['is_published'] === 1 ? 'Ya' : 'Tidak' ?></td>
                                    <td class="admin-table-actions">
                                        <a class="button button--ghost button--small" href="<?= site_url('admin/galleries/' . $gallery['id'] . '/edit') ?>">Edit</a>
                                        <form action="<?= site_url('admin/galleries/' . $gallery['id'] . '/delete') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button class="button button--ghost button--small button--danger" type="submit">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>

        <article class="panel">
            <p class="panel__label">Daftar User</p>
            <h2>Akun admin dan user publik</h2>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= esc($user['name']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['role']) ?></td>
                                <td><?= (int) $user['is_active'] === 1 ? 'Aktif' : 'Nonaktif' ?></td>
                                <td class="admin-table-actions">
                                    <a class="button button--ghost button--small" href="<?= site_url('admin/users/' . $user['id'] . '/edit') ?>">Edit</a>
                                    <form action="<?= site_url('admin/users/' . $user['id'] . '/delete') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button class="button button--ghost button--small button--danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
