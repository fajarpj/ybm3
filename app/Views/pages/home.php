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
                <p class="hero__card-label">Rekening donasi resmi</p>
                <?php foreach ($site['bankAccounts'] as $account): ?>
                    <div class="account-row">
                        <strong><?= esc($account['bank']) ?></strong>
                        <h2><?= esc($account['number']) ?></h2>
                    </div>
                <?php endforeach; ?>
                <p>a.n. <?= esc($site['bankHolder']) ?></p>
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

<a class="whatsapp-float" href="https://wa.me/6285353400700" target="_blank" rel="noopener noreferrer" aria-label="Hubungi WhatsApp YB3M Peduli">
    <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M19.05 4.91A9.82 9.82 0 0 0 12.03 2C6.56 2 2.1 6.45 2.1 11.93c0 1.75.46 3.46 1.33 4.97L2 22l5.24-1.37a9.9 9.9 0 0 0 4.78 1.22h.01c5.47 0 9.93-4.45 9.93-9.93a9.84 9.84 0 0 0-2.91-7.01Zm-7.02 15.26h-.01a8.2 8.2 0 0 1-4.17-1.14l-.3-.18-3.11.81.83-3.03-.2-.31a8.21 8.21 0 0 1-1.26-4.39c0-4.53 3.69-8.22 8.23-8.22a8.17 8.17 0 0 1 5.82 2.41 8.16 8.16 0 0 1 2.41 5.81c0 4.54-3.69 8.24-8.24 8.24Zm4.51-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.78.96-.14.16-.29.18-.54.06-.25-.12-1.06-.39-2.02-1.26-.74-.66-1.25-1.48-1.4-1.73-.15-.24-.01-.37.11-.49.11-.11.25-.29.37-.43.12-.15.16-.25.24-.41.08-.17.04-.31-.02-.43-.07-.12-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43h-.47c-.16 0-.43.06-.65.31-.23.24-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.64 4.2 3.71.59.26 1.05.42 1.41.54.59.19 1.12.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.28Z"/>
    </svg>
</a>

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
