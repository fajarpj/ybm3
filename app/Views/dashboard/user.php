<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$paidDonations = array_values(array_filter($donations, static fn (array $item): bool => $item['payment_status'] === 'paid'));
$pendingDonations = array_values(array_filter($donations, static fn (array $item): bool => $item['payment_status'] === 'pending'));
$failedDonations = array_values(array_filter($donations, static fn (array $item): bool => $item['payment_status'] === 'failed'));
$totalDonatedAmount = array_reduce($paidDonations, static fn (float $carry, array $item): float => $carry + (float) $item['amount'], 0.0);
$latestDonation = $donations[0] ?? null;
?>

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

        <div class="user-stats-grid">
            <article class="info-card user-stat-card">
                <p class="panel__label">Total Transaksi</p>
                <h3><?= count($donations) ?></h3>
                <p>Seluruh riwayat donasi yang pernah tercatat di akun Anda.</p>
            </article>
            <article class="info-card user-stat-card">
                <p class="panel__label">Dana Terkonfirmasi</p>
                <h3>Rp<?= number_format($totalDonatedAmount, 0, ',', '.') ?></h3>
                <p>Akumulasi nominal donasi dengan status pembayaran berhasil.</p>
            </article>
            <article class="info-card user-stat-card">
                <p class="panel__label">Menunggu Pembayaran</p>
                <h3><?= count($pendingDonations) ?></h3>
                <p>Transaksi yang masih bisa Anda lanjutkan pembayarannya.</p>
            </article>
            <article class="info-card user-stat-card">
                <p class="panel__label">Status Terakhir</p>
                <h3><?= esc(ucfirst($latestDonation['payment_status'] ?? 'belum ada')) ?></h3>
                <p><?= $latestDonation ? 'Pembaharuan terakhir dari transaksi ' . esc($latestDonation['transaction_code']) . '.' : 'Belum ada transaksi yang tercatat di akun ini.' ?></p>
            </article>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container user-dashboard-grid">
        <article class="panel account-panel">
            <p class="panel__label">Pengaturan Akun</p>
            <h2>Perbarui email dan password Anda</h2>
            <p class="section-intro">Gunakan password saat ini untuk mengonfirmasi perubahan, lalu simpan pembaruan akun Anda dengan aman.</p>
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

        <article class="panel user-side-panel">
            <p class="panel__label">Ringkasan Akun</p>
            <h2>Pantau donasi Anda dengan lebih jelas</h2>
            <div class="stack">
                <div class="list-row">
                    <strong class="user-side-panel__value"><?= count($paidDonations) ?></strong>
                    <span>transaksi berhasil sudah tercatat sebagai donasi terkonfirmasi.</span>
                </div>
                <div class="list-row">
                    <strong class="user-side-panel__value"><?= count($failedDonations) ?></strong>
                    <span>transaksi gagal tetap disimpan sebagai riwayat agar mudah ditinjau kembali.</span>
                </div>
                <div class="list-row">
                    <strong class="user-side-panel__value"><?= esc($userRecord['email'] ?? $authUser['email']) ?></strong>
                    <span>email aktif yang digunakan untuk login dan pelacakan dashboard.</span>
                </div>
            </div>
            <div class="dashboard-links">
                <a class="button button--primary" href="<?= site_url('donasi') ?>">Buat Donasi Baru</a>
            </div>
        </article>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="panel user-transactions-panel">
            <div class="section-heading section-heading--split user-transactions-heading">
                <div>
                    <p class="panel__label">Riwayat Transaksi</p>
                    <h2>Semua aktivitas donasi akun Anda</h2>
                </div>
                <p class="section-intro">Status akan berubah otomatis saat admin memperbarui transaksi atau saat notifikasi Midtrans masuk ke sistem.</p>
            </div>

            <?php if ($donations === []): ?>
                <div class="user-empty-state">
                    <h3>Belum ada riwayat donasi</h3>
                    <p>Setelah Anda mengirim donasi, transaksi akan muncul di sini lengkap dengan status pembayaran dan tautan lanjut bayar.</p>
                    <a class="button button--primary" href="<?= site_url('donasi') ?>">Mulai Donasi</a>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="data-table user-data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Order ID</th>
                                <th>Nominal</th>
                                <th>Gateway</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $donation): ?>
                                <?php
                                $status = strtolower((string) $donation['payment_status']);
                                $statusClass = match ($status) {
                                    'paid' => 'status-badge status-badge--paid',
                                    'failed' => 'status-badge status-badge--failed',
                                    default => 'status-badge status-badge--pending',
                                };
                                $canPay = ! empty($donation['payment_url']) && $status === 'pending';
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($donation['transaction_code']) ?></strong>
                                    </td>
                                    <td><?= esc($donation['order_id'] ?? '-') ?></td>
                                    <td>Rp<?= number_format((float) $donation['amount'], 0, ',', '.') ?></td>
                                    <td><?= esc($donation['payment_gateway']) ?></td>
                                    <td><span class="<?= $statusClass ?>"><?= esc(ucfirst($status)) ?></span></td>
                                    <td>
                                        <?php if ($canPay): ?>
                                            <a class="button button--ghost button--small" href="<?= esc($donation['payment_url']) ?>" target="_blank" rel="noreferrer">Bayar</a>
                                        <?php elseif ($status === 'paid'): ?>
                                            <span class="table-note">Selesai</span>
                                        <?php elseif ($status === 'failed'): ?>
                                            <span class="table-note">Gagal</span>
                                        <?php else: ?>
                                            <span class="table-note">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
