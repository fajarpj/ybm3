<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro page-intro--donation donation-intro">
    <div class="container donation-hero">
        <article class="donation-hero__copy">
            <p class="eyebrow">Donasi Digital</p>
            <h1>Donasi online yang rapi, cepat, dan langsung terhubung ke payment gateway resmi</h1>
            <p class="donation-hero__lead"><?= esc($description) ?></p>
            <div class="donation-hero__safe-note">
                <span>Pembayaran aman via Midtrans</span>
                <?php if ($midtransReady): ?>
                    <small>User akan diarahkan ke halaman pembayaran resmi Midtrans setelah formulir dikirim.</small>
                <?php else: ?>
                    <small>Gateway belum siap karena `server key` dan `client key` belum lengkap di `.env`.</small>
                <?php endif; ?>
            </div>

            <div class="donation-hero__steps">
                <?php foreach ($donationSteps as $step): ?>
                    <div class="donation-hero__step">
                        <span></span>
                        <p><?= esc($step) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>
    </div>
</section>

<section class="section section--muted donation-section">
    <div class="container donation-layout">
        <article class="panel donation-form-panel">
            <div class="donation-form-panel__heading">
                <div>
                    <p class="panel__label">Form Donasi</p>
                    <h2>Tunaikan donasi Anda dalam beberapa langkah</h2>
                </div>
                <div class="donation-auth-compact">
                    <?php if (! empty($authUser)): ?>
                        <span class="status-badge status-badge--paid">Login</span>
                        <p>Donasi akan tercatat ke dashboard <?= esc($authUser['name']) ?>.</p>
                    <?php else: ?>
                        <span class="status-badge status-badge--pending">Belum Login</span>
                        <p>Login atau daftar agar riwayat donasi bisa dicek kembali kapan saja.</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form class="donation-form donation-form--clean" action="<?= site_url('donasi/kirim') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="payment_gateway" value="Midtrans Snap">

                <label class="form-field">
                    <span>Nama donatur</span>
                    <input type="text" name="donor_name" value="<?= old('donor_name', $authUser['name'] ?? '') ?>" placeholder="Nama lengkap">
                </label>

                <label class="form-field">
                    <span>No. HP</span>
                    <input type="text" name="donor_phone" value="<?= old('donor_phone') ?>" placeholder="08xxxxxxxxxx">
                </label>

                <label class="form-field form-field--full">
                    <span>Pilih program</span>
                    <select name="program_id">
                        <option value="">Umum / Donasi terbaik</option>
                        <?php foreach ($programOptions as $program): ?>
                            <option value="<?= esc($program['id']) ?>" <?= old('program_id') == $program['id'] ? 'selected' : '' ?>>
                                <?= esc(mb_strimwidth($program['judul'], 0, 52, '...')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-helper">Pilih program yang ingin didukung. Detail donasi tetap tercatat penuh di dashboard admin dan user.</small>
                </label>

                <label class="form-field">
                    <span>Nominal donasi</span>
                    <input type="number" name="amount" value="<?= old('amount') ?>" min="10000" step="1000" placeholder="100000">
                </label>

                <div class="form-field donation-gateway-fixed">
                    <span>Gateway pembayaran</span>
                    <div class="gateway-fixed-card">
                        <strong>Midtrans Snap</strong>
                        <p>QRIS, virtual account, e-wallet, dan metode aktif lainnya dipilih di halaman Midtrans.</p>
                    </div>
                </div>

                <label class="form-field form-field--full">
                    <span>Pesan / niat baik</span>
                    <textarea name="message" rows="4" placeholder="Tuliskan doa atau keterangan singkat"><?= old('message') ?></textarea>
                </label>

                <div class="donation-form__footer form-field--full">
                    <button class="button button--primary" type="submit">Lanjutkan ke Midtrans</button>
                    <p>Dengan menekan tombol di atas, sistem akan membuat transaksi dan mengarahkan Anda ke halaman pembayaran resmi Midtrans.</p>
                </div>
            </form>
        </article>

        <aside class="donation-sidebar">
            <article class="panel donation-login-panel">
                <p class="panel__label">Akun Donatur</p>
                <h2>Login dan register</h2>
                <p>Simpan riwayat donasi, cek status transaksi, dan lihat tautan pembayaran Anda kembali dari dashboard user.</p>
                <div class="dashboard-links donation-login-links">
                    <?php if (empty($authUser)): ?>
                        <a class="button button--ghost" href="<?= site_url('login') ?>">Login</a>
                        <a class="button button--primary" href="<?= site_url('register') ?>">Daftar Akun</a>
                    <?php else: ?>
                        <a class="button button--primary" href="<?= site_url(($authUser['role'] ?? 'user') === 'admin' ? 'admin' : 'dashboard') ?>">Buka Dashboard</a>
                    <?php endif; ?>
                </div>
            </article>

            <article class="panel donation-sidebar__trust">
                <p class="panel__label">Catatan</p>
                <div class="stack">
                    <div class="list-row">Setelah transaksi dibuat, user akan diarahkan ke halaman Midtrans resmi.</div>
                    <div class="list-row">Status pembayaran akan tersinkron ke dashboard admin dan dashboard user.</div>
                    <div class="list-row">Tampilan halaman ini sudah dioptimalkan untuk mobile dan desktop.</div>
                </div>
            </article>
        </aside>
    </div>
</section>
<?= $this->endSection() ?>
