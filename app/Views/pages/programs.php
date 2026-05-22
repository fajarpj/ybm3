<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro page-intro--compact">
    <div class="container narrow page-intro__stack">
        <p class="eyebrow">Program yayasan</p>
        <h1>Campaign donasi dan program manfaat</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section section--intro-linked">
    <div class="container campaign-grid">
        <?php foreach ($programs as $program): ?>
            <article class="campaign-card">
                <a class="campaign-card__image" href="<?= site_url('program/' . $program['slug']) ?>">
                    <img src="<?= base_url($program['gambar']) ?>" alt="<?= esc($program['judul']) ?>">
                    <span class="campaign-card__badge"><?= esc($program['status']) ?></span>
                </a>
                <div class="campaign-card__body">
                    <p class="panel__label">Program Donasi</p>
                    <h2><a href="<?= site_url('program/' . $program['slug']) ?>"><?= esc($program['judul']) ?></a></h2>
                    <p><?= esc($program['deskripsi']) ?></p>
                    <div class="progress-block">
                        <div class="progress-meta">
                            <strong>Rp<?= number_format((float) $program['terkumpul'], 0, ',', '.') ?></strong>
                            <span>dari target Rp<?= number_format((float) $program['target_dana'], 0, ',', '.') ?></span>
                        </div>
                        <div class="progress-bar">
                            <span style="width: <?= esc((string) $program['progress_percent']) ?>%"></span>
                        </div>
                    </div>
                    <div class="campaign-card__footer">
                        <span><?= esc($program['donation_label']) ?> • <?= esc((string) $program['progress_percent']) ?>% tercapai</span>
                        <a class="button button--primary" href="<?= site_url('program/' . $program['slug']) ?>">Lihat Detail</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
