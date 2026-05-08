<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro page-intro--donation">
    <div class="container narrow">
        <p class="eyebrow">Donasi</p>
        <h1>Salurkan donasi dengan jalur pembayaran yang resmi</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container donation-grid">
        <article class="panel panel--accent donation-highlight">
            <p class="panel__label">Rekening donasi resmi</p>
            <?php foreach ($site['bankAccounts'] as $account): ?>
                <div class="account-row">
                    <strong><?= esc($account['bank']) ?></strong>
                    <p class="donation-account"><?= esc($account['number']) ?></p>
                </div>
            <?php endforeach; ?>
            <p>a.n. <?= esc($site['bankHolder']) ?></p>
        </article>

        <article class="panel">
            <p class="panel__label">Alur donasi</p>
            <div class="stack">
                <?php foreach ($donationSteps as $step): ?>
                    <div class="list-row"><?= esc($step) ?></div>
                <?php endforeach; ?>
            </div>
            <?php if (! empty($authUser)): ?>
                <div class="alert alert--success">Anda login sebagai <?= esc($authUser['name']) ?>. Donasi akan masuk ke dashboard akun Anda.</div>
            <?php else: ?>
                <div class="alert alert--info">Agar riwayat donasi bisa dicek kembali, sebaiknya login atau daftar terlebih dahulu.</div>
            <?php endif; ?>
        </article>
    </div>
</section>

<section class="section section--muted">
    <div class="container two-column">
        <article class="panel">
            <p class="panel__label">Form donasi</p>
            <h2>Midtrans sebagai gateway utama</h2>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?php if (! $midtransReady): ?>
                <div class="alert alert--warn">Midtrans belum live karena `server key` dan `client key` belum diisi di `.env`.</div>
            <?php endif; ?>

            <form class="donation-form" action="<?= site_url('donasi/kirim') ?>" method="post">
                <?= csrf_field() ?>
                <label class="form-field">
                    <span>Nama donatur</span>
                    <input type="text" name="donor_name" value="<?= old('donor_name', $authUser['name'] ?? '') ?>" placeholder="Nama lengkap">
                </label>
                <label class="form-field">
                    <span>No. HP</span>
                    <input type="text" name="donor_phone" value="<?= old('donor_phone') ?>" placeholder="08xxxxxxxxxx">
                </label>
                <label class="form-field">
                    <span>Pilih program</span>
                    <select name="program_id">
                        <option value="">Umum / Donasi terbaik</option>
                        <?php foreach ($programOptions as $program): ?>
                            <option value="<?= esc($program['id']) ?>" <?= old('program_id') == $program['id'] ? 'selected' : '' ?>><?= esc($program['judul']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="form-field">
                    <span>Nominal donasi</span>
                    <input type="number" name="amount" value="<?= old('amount') ?>" min="10000" step="1000" placeholder="100000">
                </label>
                <label class="form-field">
                    <span>Payment gateway</span>
                    <select name="payment_gateway">
                        <?php foreach ($gatewayOptions as $gateway): ?>
                            <option value="<?= esc($gateway) ?>" <?= old('payment_gateway') === $gateway ? 'selected' : '' ?>><?= esc($gateway) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="form-field">
                    <span>Kanal pembayaran</span>
                    <select name="payment_channel">
                        <?php foreach ($channelOptions as $channel): ?>
                            <option value="<?= esc($channel) ?>" <?= old('payment_channel') === $channel ? 'selected' : '' ?>><?= esc($channel) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="form-field form-field--full">
                    <span>Pesan / niat baik</span>
                    <textarea name="message" rows="4" placeholder="Tuliskan doa atau keterangan singkat"><?= old('message') ?></textarea>
                </label>
                <button class="button button--primary" type="submit">Lanjutkan Donasi</button>
            </form>
        </article>

        <article class="panel">
            <p class="panel__label">Kanal pembayaran</p>
            <h2>Status transaksi dapat dikelola di dashboard</h2>
            <div class="stack">
                <?php foreach ($paymentChannels as $channel): ?>
                    <div class="list-row"><?= esc($channel) ?></div>
                <?php endforeach; ?>
            </div>
            <div class="dashboard-links">
                <?php if (empty($authUser)): ?>
                    <a class="button button--ghost" href="<?= site_url('login') ?>">Login</a>
                    <a class="button button--ghost" href="<?= site_url('register') ?>">Daftar Akun</a>
                <?php else: ?>
                    <a class="button button--ghost" href="<?= site_url(($authUser['role'] ?? 'user') === 'admin' ? 'admin' : 'dashboard') ?>">Buka Dashboard</a>
                <?php endif; ?>
            </div>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
