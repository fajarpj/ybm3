<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro page-intro--compact">
    <div class="container narrow page-intro__stack">
        <p class="eyebrow">Legal</p>
        <h1>Kebijakan Pengembalian Dana</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section section--intro-linked">
    <div class="container narrow legal-stack">
        <?php foreach ($sections as $section): ?>
            <article class="panel legal-panel">
                <p class="panel__label"><?= esc($section['title']) ?></p>
                <div class="legal-copy">
                    <?php foreach ($section['content'] as $paragraph): ?>
                        <p><?= esc($paragraph) ?></p>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
