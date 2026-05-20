<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Dashboard User</p>
        <h1>Riwayat donasi <?= esc($authUser['name']) ?></h1>
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
            <article class="info-card"><p class="panel__label">Total Donasi</p><h3><?= count($donations) ?></h3></article>
            <article class="info-card"><p class="panel__label">Status Paid</p><h3><?= count(array_filter($donations, fn ($item) => $item['payment_status'] === 'paid')) ?></h3></article>
            <article class="info-card"><p class="panel__label">Status Pending</p><h3><?= count(array_filter($donations, fn ($item) => $item['payment_status'] === 'pending')) ?></h3></article>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container">
        <article class="panel account-panel">
            <p class="panel__label">Pengaturan Akun</p>
            <h2>Perbarui email dan password Anda</h2>
            <form class="donation-form" action="<?= site_url('dashboard/account') ?>" method="post">
                <?= csrf_field() ?>
                <label class="form-field">
                    <span>Nama</span>
                    <input type="text" name="name" value="<?= esc(old('name', $userRecord['name'] ?? $authUser['name'])) ?>" placeholder="Nama lengkap">
                </label>
                <label class="form-field">
                    <span>Email</span>
                    <input type="email" name="email" value="<?= esc(old('email', $userRecord['email'] ?? $authUser['email'])) ?>" placeholder="email@domain.com">
                </label>
                <label class="form-field">
                    <span>No. HP</span>
                    <input type="text" name="phone" value="<?= esc(old('phone', $userRecord['phone'] ?? '')) ?>" placeholder="08xxxxxxxxxx">
                </label>
                <label class="form-field">
                    <span>Password saat ini</span>
                    <input type="password" name="current_password" value="" placeholder="Wajib untuk konfirmasi perubahan">
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
                    <button class="button button--primary" type="submit">Simpan Perubahan Akun</button>
                </div>
            </form>
        </article>

        <article class="panel">
            <p class="panel__label">Riwayat transaksi</p>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nominal</th>
                            <th>Gateway</th>
                            <th>Status</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $donation): ?>
                            <tr>
                                <td><?= esc($donation['transaction_code']) ?></td>
                                <td>Rp<?= number_format((float) $donation['amount'], 0, ',', '.') ?></td>
                                <td><?= esc($donation['payment_gateway']) ?></td>
                                <td><?= esc($donation['payment_status']) ?></td>
                                <td>
                                    <?php if (! empty($donation['payment_url'])): ?>
                                        <a href="<?= esc($donation['payment_url']) ?>" target="_blank" rel="noreferrer">Bayar</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
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
