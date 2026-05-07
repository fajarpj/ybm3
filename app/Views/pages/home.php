<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="hero">
    <div class="container hero__grid">
        <div>
            <p class="eyebrow">Kolaborasi yang terasa dekat</p>
            <h1><?= esc($site['name']) ?></h1>
            <p class="hero__lead"><?= esc($site['tagline']) ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?= site_url('program') ?>">Lihat Program</a>
                <a class="button button--ghost" href="<?= site_url('kontak') ?>">Ajukan Kolaborasi</a>
            </div>
        </div>
        <div class="hero__card">
            <p class="hero__card-label">Sorotan dampak</p>
            <?php foreach ($site['heroMetrics'] as $metric): ?>
                <div class="metric">
                    <strong><?= esc($metric['value']) ?></strong>
                    <span><?= esc($metric['label']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Arah pengembangan</p>
            <h2>Fondasi website yang siap dilanjutkan tim</h2>
        </div>
        <div class="card-grid">
            <?php foreach ($highlights as $highlight): ?>
                <article class="info-card">
                    <p><?= esc($highlight) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Bidang fokus</p>
            <h2>Tiga area dampak utama</h2>
        </div>
        <div class="card-grid">
            <?php foreach ($site['focusAreas'] as $area): ?>
                <article class="feature-card">
                    <h3><?= esc($area['title']) ?></h3>
                    <p><?= esc($area['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
