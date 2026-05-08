<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Dashboard Admin</p>
        <h1>Kontrol donasi dan data yayasan</h1>
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
            <article class="info-card"><p class="panel__label">Dana Tercatat</p><h3>Rp<?= number_format((float) $totalRaised, 0, ',', '.') ?></h3></article>
            <article class="info-card"><p class="panel__label">User</p><h3><?= esc((string) $userCount) ?></h3></article>
            <article class="info-card"><p class="panel__label">Program</p><h3><?= esc((string) $programCount) ?></h3></article>
            <article class="info-card"><p class="panel__label">Galeri</p><h3><?= esc((string) $galleryCount) ?></h3></article>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container">
        <article class="panel">
            <p class="panel__label">Manajemen donasi</p>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Donatur</th>
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
    </div>
</section>
<?= $this->endSection() ?>
