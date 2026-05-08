<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Gallery</p>
        <h1>Dokumentasi kegiatan dan jejak manfaat yayasan</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container gallery-grid">
        <?php foreach ($galleries as $gallery): ?>
            <article class="gallery-card">
                <div class="gallery-card__image">
                    <img src="<?= base_url($gallery['image']) ?>" alt="<?= esc($gallery['title']) ?>">
                </div>
                <div class="gallery-card__body">
                    <p class="panel__label"><?= esc($gallery['category']) ?></p>
                    <h2><?= esc($gallery['title']) ?></h2>
                    <p><?= esc($gallery['caption']) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
