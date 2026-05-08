<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Kontak</p>
        <h1>Mari bangun sinergi yang jelas, cepat, dan terpercaya</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <article class="panel">
            <p class="panel__label">Hubungi kami</p>
            <h2><?= esc($site['name']) ?></h2>
            <p>Email: <?= esc($site['email']) ?></p>
            <p>WhatsApp: <?= esc($site['phone']) ?></p>
            <p>Website: <?= esc($site['website']) ?></p>
            <p>Alamat operasional: <?= esc($site['address']) ?></p>
        </article>
        <article class="panel panel--accent">
            <p class="panel__label">Pengembangan berikutnya</p>
            <h2>Halaman ini siap ditingkatkan</h2>
            <p>Berikutnya kita bisa tambahkan formulir kontak, tombol WhatsApp otomatis, embed Google Maps, FAQ, dan integrasi database pesan masuk.</p>
        </article>
    </div>
</section>

<section class="section">
    <div class="container social-board">
        <?php foreach ($site['socials'] as $social): ?>
            <a class="social-card" href="<?= esc($social['url']) ?>" target="_blank" rel="noreferrer">
                <span class="panel__label"><?= esc($social['label']) ?></span>
                <strong><?= esc($social['value']) ?></strong>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
