<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro page-intro--donation donation-intro qris-intro">
    <div class="container qris-hero">
        <article class="qris-hero__copy">
            <p class="eyebrow">Donasi QRIS YBM3</p>
            <h1>Kebaikan Anda Menjadi Harapan Mereka</h1>
            <p class="donation-hero__lead"><?= esc($description) ?></p>
            <div class="qris-hero__badges" aria-label="Informasi QRIS">
                <span>QRIS Nasional</span>
                <span>Scan dari semua e-wallet dan mobile banking</span>
                <span>Tanpa input nominal di website</span>
            </div>
        </article>

        <article class="qris-card" aria-label="QRIS Donasi YBM3">
            <div class="qris-card__shine"></div>
            <div class="qris-card__header">
                <div>
                    <p class="panel__label">Scan Untuk Donasi</p>
                    <h2>QRIS YBM3</h2>
                </div>
                <span class="status-badge status-badge--paid">Aktif</span>
            </div>

            <figure class="qris-frame">
                <img src="<?= base_url('assets/images/payment/qris-ybm3.png') ?>" alt="QRIS donasi YBM3">
            </figure>

            <div class="qris-card__actions">
                <a class="button button--primary" href="<?= base_url('assets/images/payment/qris-ybm3.png') ?>" download>Unduh QRIS</a>
                <a class="button button--ghost" href="https://wa.me/62<?= esc(ltrim($site['phone'], '0')) ?>" target="_blank" rel="noopener">Konfirmasi Donasi</a>
            </div>
        </article>
    </div>
</section>

<section class="section section--muted qris-section">
    <div class="container qris-info-grid">
        <article class="panel qris-steps">
            <p class="panel__label">Cara Donasi</p>
            <h2>Scan, isi nominal di aplikasi, lalu selesaikan pembayaran</h2>
            <div class="qris-step-list">
                <div class="qris-step">
                    <span>1</span>
                    <p>Buka aplikasi mobile banking atau e-wallet yang mendukung QRIS.</p>
                </div>
                <div class="qris-step">
                    <span>2</span>
                    <p>Scan QRIS YBM3 di atas, lalu isi nominal donasi langsung di aplikasi Anda.</p>
                </div>
                <div class="qris-step">
                    <span>3</span>
                    <p>Periksa nama merchant YBM3, selesaikan pembayaran, dan simpan bukti transaksi.</p>
                </div>
            </div>
        </article>

        <aside class="panel qris-note">
            <p class="panel__label">Catatan Aman</p>
            <h2>Pastikan nama penerima benar</h2>
            <p>Website tidak meminta nominal donasi karena pembayaran dilakukan langsung melalui QRIS. Mohon pastikan nama penerima menampilkan YBM3 sebelum menyelesaikan transaksi.</p>
            <div class="qris-note__contact">
                <span>Butuh bantuan?</span>
                <strong><?= esc($site['phone']) ?></strong>
            </div>
        </aside>
    </div>
</section>
<?= $this->endSection() ?>
