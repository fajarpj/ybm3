<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Program yayasan</p>
        <h1>Program yang mewakili bakti sosial, pembinaan, dan kemandirian</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container stack">
        <?php foreach ($programs as $program): ?>
            <article class="program-card">
                <div>
                    <p class="panel__label">Program</p>
                    <h2><?= esc($program['judul']) ?></h2>
                    <p><?= esc($program['deskripsi']) ?></p>
                </div>
                <div class="program-card__impact">
                    <p class="panel__label">Target dan progres</p>
                    <strong>Target Rp<?= number_format((float) $program['target_dana'], 0, ',', '.') ?></strong>
                    <p>Terkumpul Rp<?= number_format((float) $program['terkumpul'], 0, ',', '.') ?></p>
                    <p>Status: <?= esc($program['status']) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
