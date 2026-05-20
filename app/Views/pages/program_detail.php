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
            </div>
        </div>

        <aside class="program-sidebar">
            <article class="panel donation-card-sticky">
                <p class="panel__label">Ayo Berdonasi</p>
                <h2>Dukung program ini sekarang</h2>
                <p class="sidebar-copy">Form cepat ini dibuat seperti pola campaign modern: fokus, ringkas, dan tetap nyaman dipakai di layar kecil.</p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>
                <?php if (! $midtransReady): ?>
                    <div class="alert alert--warn">Midtrans belum dikonfigurasi. Donasi manual masih bisa dicatat terlebih dahulu.</div>
                <?php endif; ?>

                <div class="amount-pills">
                    <?php foreach ($suggestedAmounts as $amount): ?>
                        <button type="button" class="amount-pill" data-amount-pill="<?= esc((string) $amount) ?>">Rp<?= number_format((float) $amount, 0, ',', '.') ?></button>
                    <?php endforeach; ?>
                </div>

                <form class="donation-form donation-form--single" action="<?= site_url('donasi/kirim') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="program_id" value="<?= esc((string) $program['id']) ?>">
                    <label class="form-field">
                        <span>Nama donatur</span>
                        <input type="text" name="donor_name" value="<?= old('donor_name', $authUser['name'] ?? '') ?>" placeholder="Nama lengkap">
                    </label>
                    <label class="form-field">
                        <span>No. HP</span>
                        <input type="text" name="donor_phone" value="<?= old('donor_phone') ?>" placeholder="08xxxxxxxxxx">
                    </label>
                    <label class="form-field">
                        <span>Nominal donasi</span>
                        <input type="number" id="quick-donation-amount" name="amount" value="<?= old('amount') ?>" min="10000" step="1000" placeholder="100000">
                    </label>
                    <label class="form-field">
                        <span>Payment gateway</span>
                        <select name="payment_gateway" data-gateway-select>
                            <?php foreach ($gatewayOptions as $gateway): ?>
                                <option value="<?= esc($gateway) ?>"><?= esc($gateway) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <div class="form-field gateway-note" data-midtrans-note>
                        <span>Metode pembayaran Midtrans</span>
                        <p>Setelah lanjut, pilihan seperti QRIS, Virtual Account, GoPay, ShopeePay, dan metode aktif lainnya akan muncul langsung di Snap Midtrans.</p>
                    </div>
                    <label class="form-field" data-manual-channel-field hidden>
                        <span>Rekening tujuan transfer manual</span>
                        <select name="payment_channel">
                            <option value="">Pilih rekening tujuan</option>
                            <?php foreach ($manualChannelOptions as $channel): ?>
                                <option value="<?= esc($channel) ?>"><?= esc($channel) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="form-field">
                        <span>Pesan</span>
                        <textarea name="message" rows="3" placeholder="Doa atau keterangan singkat"><?= old('message') ?></textarea>
                    </label>
                    <button class="button button--primary" type="submit">Donasi Sekarang</button>
                </form>
            </article>
        </aside>
    </div>
</section>

<script>
    (() => {
        const amountInput = document.getElementById('quick-donation-amount');
        const pills = document.querySelectorAll('[data-amount-pill]');
        const gatewaySelect = document.querySelector('[data-gateway-select]');
        const manualField = document.querySelector('[data-manual-channel-field]');
        const midtransNote = document.querySelector('[data-midtrans-note]');
        const manualSelect = manualField?.querySelector('select');

        if (!amountInput || !pills.length) {
            return;
        }

        pills.forEach((pill) => {
            pill.addEventListener('click', () => {
                amountInput.value = pill.getAttribute('data-amount-pill');
                amountInput.focus();
            });
        });

        if (gatewaySelect && manualField && midtransNote) {
            const syncGatewayUI = () => {
                const isMidtrans = gatewaySelect.value.toLowerCase().includes('midtrans');
                manualField.hidden = isMidtrans;
                midtransNote.hidden = !isMidtrans;

                if (isMidtrans && manualSelect) {
                    manualSelect.value = '';
                }
            };

            gatewaySelect.addEventListener('change', syncGatewayUI);
            syncGatewayUI();
        }
    })();
</script>
<?= $this->endSection() ?>
