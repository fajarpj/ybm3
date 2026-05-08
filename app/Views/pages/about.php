<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Tentang yayasan</p>
        <h1>Profil Yayasan Bakti Mulya Masyarakat Mandiri</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <article class="panel">
            <p class="panel__label">Arah pengabdian</p>
            <h2>Menjadi yayasan yang hadir dengan bakti, mulya, dan semangat kemandirian masyarakat.</h2>
            <p>Halaman ini dapat terus dikembangkan untuk memuat sejarah yayasan, legalitas lembaga, struktur pengurus, dan penguatan kepercayaan publik.</p>
        </article>
        <article class="panel">
            <p class="panel__label">Nilai kerja</p>
            <?php foreach ($principles as $principle): ?>
                <div class="list-row"><?= esc($principle) ?></div>
            <?php endforeach; ?>
        </article>
    </div>
</section>

<section class="section section--muted">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Misi yayasan</p>
            <h2>Langkah yang membawa manfaat lebih terarah</h2>
        </div>
        <div class="card-grid">
            <?php foreach ($missions as $mission): ?>
                <article class="info-card">
                    <p><?= esc($mission) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
