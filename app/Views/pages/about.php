<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Tentang kami</p>
        <h1>Yayasan yang dibangun untuk kerja lapangan yang konsisten</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <article class="panel">
            <p class="panel__label">Visi</p>
            <h2>Mendorong komunitas tumbuh dengan akses yang lebih adil.</h2>
            <p>Kami percaya perubahan sosial yang sehat lahir dari hubungan yang kuat antara warga, relawan, mitra, dan pengelola program.</p>
        </article>
        <article class="panel">
            <p class="panel__label">Cara kerja</p>
            <?php foreach ($principles as $principle): ?>
                <div class="list-row"><?= esc($principle) ?></div>
            <?php endforeach; ?>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
