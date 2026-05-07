<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Program yayasan</p>
        <h1>Program yang bisa langsung dipahami calon mitra</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container stack">
        <?php foreach ($programs as $program): ?>
            <article class="program-card">
                <div>
                    <p class="panel__label">Program</p>
                    <h2><?= esc($program['name']) ?></h2>
                    <p><?= esc($program['summary']) ?></p>
                </div>
                <div class="program-card__impact">
                    <p class="panel__label">Dampak saat ini</p>
                    <strong><?= esc($program['impact']) ?></strong>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
