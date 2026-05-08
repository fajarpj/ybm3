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
        <div class="stats-grid">
            <article class="info-card"><p class="panel__label">Total Donasi</p><h3><?= count($donations) ?></h3></article>
            <article class="info-card"><p class="panel__label">Status Paid</p><h3><?= count(array_filter($donations, fn ($item) => $item['payment_status'] === 'paid')) ?></h3></article>
            <article class="info-card"><p class="panel__label">Status Pending</p><h3><?= count(array_filter($donations, fn ($item) => $item['payment_status'] === 'pending')) ?></h3></article>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container">
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
