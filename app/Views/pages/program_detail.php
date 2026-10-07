<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="program-hero">
    <div class="container program-hero__grid">
        <div class="program-hero__main">
            <div class="program-hero__image">
                <img src="<?= base_url($program['gambar']) ?>" alt="<?= esc($program['judul']) ?>">
            </div>

            <article class="program-summary">
                <p class="eyebrow">Program Donasi</p>
                <h1><?= esc($program['judul']) ?></h1>
                <p class="program-summary__lead"><?= esc($program['deskripsi']) ?></p>
                <div class="program-summary__status">
                    <span class="status-badge <?= $program['status'] === 'aktif' ? 'status-badge--paid' : 'status-badge--failed' ?>">
                        <?= esc($program['status'] === 'aktif' ? 'Donasi Dibuka' : 'Program Selesai') ?>
                    </span>
                </div>

                <div class="program-stats">
                    <div class="stat-chip">
                        <strong>Rp<?= number_format((float) $program['terkumpul'], 0, ',', '.') ?></strong>
                        <span>Terkumpul</span>
                    </div>
                    <div class="stat-chip">
                        <strong>Rp<?= number_format((float) $program['target_dana'], 0, ',', '.') ?></strong>
                        <span>Target</span>
                    </div>
                    <div class="stat-chip">
                        <strong><?= esc((string) $program['progress_percent']) ?>%</strong>
                        <span>Progress</span>
                    </div>
                    <div class="stat-chip">
                        <strong><?= esc((string) $program['donor_count']) ?></strong>
                        <span>Donatur</span>
                    </div>
                </div>

                <div class="progress-block progress-block--large">
                    <div class="progress-meta">
                        <strong>Rp<?= number_format((float) $program['terkumpul'], 0, ',', '.') ?></strong>
                        <span>dari target Rp<?= number_format((float) $program['target_dana'], 0, ',', '.') ?></span>
                    </div>
                    <div class="progress-bar">
                        <span style="width: <?= esc((string) $program['progress_percent']) ?>%"></span>
                    </div>
                </div>
            </article>

            <div class="program-tabs">
                <section class="panel">
                    <p class="panel__label">Deskripsi</p>
                    <h2>Tentang program</h2>
                    <p><?= esc($program['deskripsi']) ?></p>
                    <div class="program-story">
                        <div class="program-story__item">
                            <strong>Fokus penyaluran</strong>
                            <p>Program ini dirancang untuk menghadirkan manfaat langsung yang terukur, relevan dengan kebutuhan lapangan, dan mudah dipantau oleh donatur.</p>
                        </div>
                        <div class="program-story__item">
                            <strong>Pelaporan donasi</strong>
                            <p>Setiap transaksi tersimpan ke database dan dapat dilihat kembali melalui dashboard user maupun dashboard admin untuk menjaga akuntabilitas.</p>
                        </div>
                        <div class="program-story__item">
                            <strong>Status program</strong>
                            <p><?= esc($program['days_label']) ?>. Campaign tetap ditampilkan dengan pendekatan yang ringkas agar nyaman dibuka dari desktop maupun mobile.</p>
                        </div>
                    </div>
                </section>

                <?php if ($program['status'] === 'aktif'): ?>
                    <section class="panel">
                        <p class="panel__label">Donatur</p>
                        <h2>Donatur terbaru</h2>
                        <div class="donor-list">
                            <?php if ($recentDonors === []): ?>
                                <div class="donor-row">
                                    <strong>Belum ada data donatur</strong>
                                    <span>Riwayat donatur akan muncul di sini setelah transaksi pertama berstatus paid.</span>
                                </div>
                            <?php endif; ?>

                            <?php foreach ($recentDonors as $donor): ?>
                                <div class="donor-row">
                                    <strong><?= esc($donor['donor_name']) ?></strong>
                                    <span>
                                        Rp<?= number_format((float) $donor['amount'], 0, ',', '.') ?>
                                        •
                                        <?= esc(date('d M Y', strtotime($donor['paid_at'] ?: $donor['created_at']))) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>

        <aside class="program-sidebar">
            <article class="panel donation-card-sticky">
                <p class="panel__label">Ayo Berdonasi</p>
                <h2><?= $program['status'] === 'aktif' ? 'Scan QRIS untuk mendukung program ini' : 'Program ini telah selesai' ?></h2>
                <p class="sidebar-copy">
                    <?= $program['status'] === 'aktif'
                        ? 'Donasi dilakukan langsung melalui QRIS YBM3. Isi nominal dari aplikasi mobile banking atau e-wallet Anda setelah QRIS dipindai.'
                        : 'Pengurus telah menandai program ini sebagai selesai, sehingga donasi baru untuk campaign ini sudah ditutup.' ?>
                </p>

                <?php if ($program['status'] === 'aktif'): ?>
                    <div class="program-qris-mini">
                        <img src="<?= base_url('assets/images/payment/qris-ybm3.png') ?>" alt="QRIS donasi YBM3">
                    </div>
                    <a class="button button--primary donation-card-sticky__button" href="<?= site_url('donasi') ?>">Buka QRIS Donasi</a>
                <?php else: ?>
                    <div class="program-closed-note">
                        <strong>Donasi ditutup</strong>
                        <p>Campaign ini tetap dapat dilihat sebagai arsip manfaat, tetapi form donasi sudah dinonaktifkan oleh admin.</p>
                        <a class="button button--ghost donation-card-sticky__button" href="<?= site_url('program') ?>">Lihat Program Lain</a>
                    </div>
                <?php endif; ?>
            </article>
        </aside>
    </div>
</section>
<?= $this->endSection() ?>
