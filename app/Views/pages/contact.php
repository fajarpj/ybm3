<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Kontak</p>
        <h1>Mari bangun kerja sama yang jelas dan berdampak</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <article class="panel">
            <p class="panel__label">Hubungi kami</p>
            <h2><?= esc($site['name']) ?></h2>
            <p>Email: <?= esc($site['email']) ?></p>
            <p>Telepon: <?= esc($site['phone']) ?></p>
            <p>Alamat: <?= esc($site['address']) ?></p>
        </article>
        <article class="panel panel--accent">
            <p class="panel__label">Bisa dilanjutkan berikutnya</p>
            <h2>Halaman ini siap ditingkatkan</h2>
            <p>Tim Anda bisa menambahkan formulir kontak, integrasi WhatsApp, Google Maps, atau penyimpanan pesan ke database tanpa mengubah struktur dasar halaman.</p>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
