<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="hero hero--with-slider">
    <div class="container hero-slider">
        <div class="hero-slider__viewport" data-slider>
            <?php foreach ($heroSlides as $index => $slide): ?>
                <article class="hero-slide <?= $index === 0 ? 'is-active' : '' ?>" data-slide>
                    <div class="hero-slide__image">
                        <img src="<?= base_url($slide['image']) ?>" alt="<?= esc($slide['title']) ?>">
                    </div>
                    <div class="hero-slide__overlay">
                        <p class="eyebrow"><?= esc($slide['category']) ?></p>
                        <h2><?= esc($slide['title']) ?></h2>
                        <p><?= esc($slide['caption']) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="hero-slider__dots">
            <?php foreach ($heroSlides as $index => $slide): ?>
                <button class="hero-slider__dot <?= $index === 0 ? 'is-active' : '' ?>" type="button" data-slide-dot aria-label="Pilih slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container hero__grid">
        <div class="hero__content">
            <p class="eyebrow"><?= esc($bismillah) ?></p>
            <p class="hero__greeting"><?= esc($greeting) ?></p>
            <h1><?= esc($site['name']) ?></h1>
            <p class="hero__lead"><?= esc($site['tagline']) ?></p>
            <p class="hero__verse"><?= esc($verse) ?></p>
            <p class="hero__closing"><?= esc($closing) ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?= site_url('donasi') ?>">Donasi Sekarang</a>
                <a class="button button--ghost" href="<?= site_url('gallery') ?>">Lihat Gallery</a>
            </div>
            <article class="hero-donation-inline">
                <p class="hero-donation-inline__label">Total dana terkumpul</p>
                <div class="hero-donation-inline__amount">
                    Rp<?= number_format((float) $donationOverview['totalRaised'], 0, ',', '.') ?>
                </div>
                <p class="hero-donation-inline__target">
                    dari target Rp<?= number_format((float) $donationOverview['totalTarget'], 0, ',', '.') ?> untuk seluruh program aktif
                </p>
                <div class="progress-bar progress-bar--dark hero-donation-inline__progress">
                    <span style="width: <?= esc((string) $donationOverview['progressPercent']) ?>%"></span>
                </div>
                <div class="hero-donation-inline__meta">
                    <div>
                        <strong><?= esc((string) $donationOverview['donationCount']) ?></strong>
                        <span>Donasi masuk</span>
                    </div>
                    <div>
                        <strong><?= esc((string) $donationOverview['activePrograms']) ?></strong>
                        <span>Program aktif</span>
                    </div>
                </div>
            </article>
        </div>
        <aside class="hero__aside">
            <article class="hero__card hero__card--accent">
                <p class="hero__card-label">Informasi yayasan</p>
                <div class="hero-info-list">
                    <div class="hero-info-list__item">
                        <strong>Identitas lembaga</strong>
                        <p><?= esc($site['name']) ?></p>
                    </div>
                    <div class="hero-info-list__item">
                        <strong>Alamat operasional</strong>
                        <p><?= esc($site['address']) ?></p>
                    </div>
                    <div class="hero-info-list__item">
                        <strong>Keterangan</strong>
                        <p><?= esc($site['officeNote']) ?></p>
                    </div>
                </div>
            </article>
            <article class="hero__card">
                <p class="hero__card-label">Nilai utama yayasan</p>
                <?php foreach ($site['heroMetrics'] as $metric): ?>
                    <div class="metric">
                        <strong><?= esc($metric['value']) ?></strong>
                        <span><?= esc($metric['label']) ?></span>
                    </div>
                <?php endforeach; ?>
            </article>
        </aside>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading section-heading--split">
            <div>
                <p class="eyebrow">Arah pengembangan</p>
                <h2>Website yayasan yang lebih teduh, terpercaya, dan siap tumbuh</h2>
            </div>
            <p class="section-intro">Tampilan beranda ini disusun seperti website yayasan pada umumnya: ada slider dokumentasi, profil singkat, program utama, dan jalur donasi yang mudah dijangkau.</p>
        </div>
        <div class="card-grid">
            <?php foreach ($highlights as $highlight): ?>
                <article class="info-card">
                    <p class="panel__label"><?= esc($highlight['title']) ?></p>
                    <p><?= esc($highlight['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--muted">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Bidang pelayanan</p>
            <h2>Fokus manfaat Yayasan Bakti Mulya Masyarakat Mandiri</h2>
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

<section class="section">
    <div class="container impact-grid">
        <article class="panel panel--accent">
            <p class="panel__label">Program prioritas</p>
            <h2>Konten kegiatan dapat langsung diarahkan ke dokumentasi lapangan dan progres manfaat</h2>
            <div class="stack">
                <?php foreach ($quickPrograms as $program): ?>
                    <div class="list-row list-row--light"><?= esc($program) ?></div>
                <?php endforeach; ?>
            </div>
        </article>
        <article class="panel">
            <p class="panel__label">Transparansi</p>
            <h2>Fondasi digital untuk galeri, donasi, dan pengelolaan data</h2>
            <div class="stack">
                <?php foreach ($trustPoints as $point): ?>
                    <div class="list-row"><?= esc($point) ?></div>
                <?php endforeach; ?>
            </div>
        </article>
    </div>
</section>

<section class="section section--soft">
    <div class="container cta-banner">
        <div>
            <p class="eyebrow">YB3M Peduli</p>
            <h2>Salam hormat kami, Pengurus YB3M Peduli</h2>
        </div>
        <div class="cta-banner__actions">
            <a class="button button--primary" href="<?= site_url('donasi') ?>">Buka Donasi</a>
            <a class="button button--ghost" href="<?= site_url('gallery') ?>">Buka Gallery</a>
        </div>
    </div>
</section>

<script>
    (() => {
        const slides = document.querySelectorAll('[data-slide]');
        const dots = document.querySelectorAll('[data-slide-dot]');
        if (!slides.length || !dots.length) {
            return;
        }

        let activeIndex = 0;

        const showSlide = (index) => {
            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('is-active', slideIndex === index);
            });
            dots.forEach((dot, dotIndex) => {
                dot.classList.toggle('is-active', dotIndex === index);
            });
            activeIndex = index;
        };

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });

        setInterval(() => {
            showSlide((activeIndex + 1) % slides.length);
        }, 4500);
    })();
</script>
<?= $this->endSection() ?>
