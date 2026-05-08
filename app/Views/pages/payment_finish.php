<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Pembayaran</p>
        <h1>Pembayaran sedang diproses</h1>
        <p><?= esc($description) ?></p>
        <div class="hero__actions">
            <a class="button button--primary" href="<?= site_url('dashboard') ?>">Cek Dashboard User</a>
            <a class="button button--ghost" href="<?= site_url('donasi') ?>">Kembali ke Donasi</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
