<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | <?= esc($site['name']) ?></title>
    <meta name="description" content="<?= esc($description ?? $site['tagline']) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/site.css') ?>">
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <div class="container site-header__inner">
                <a class="brand" href="<?= site_url('/') ?>">
                    <span class="brand__eyebrow">CI4 Website</span>
                    <span class="brand__name"><?= esc($site['name']) ?></span>
                </a>

                <?php
                $path = trim($currentUri ?? '', '/');
                $isActive = static fn (string $target): string => $path === trim($target, '/') ? 'is-active' : '';
                ?>

                <nav class="site-nav" aria-label="Navigasi utama">
                    <a class="<?= $isActive('/') ?>" href="<?= site_url('/') ?>">Beranda</a>
                    <a class="<?= $isActive('tentang') ?>" href="<?= site_url('tentang') ?>">Tentang</a>
                    <a class="<?= $isActive('program') ?>" href="<?= site_url('program') ?>">Program</a>
                    <a class="<?= $isActive('kontak') ?>" href="<?= site_url('kontak') ?>">Kontak</a>
                </nav>
            </div>
        </header>

        <main>
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="site-footer">
            <div class="container site-footer__grid">
                <div>
                    <p class="footer-label">Tentang yayasan</p>
                    <h2><?= esc($site['name']) ?></h2>
                    <p><?= esc($site['tagline']) ?></p>
                </div>
                <div>
                    <p class="footer-label">Kontak</p>
                    <p><?= esc($site['email']) ?></p>
                    <p><?= esc($site['phone']) ?></p>
                    <p><?= esc($site['address']) ?></p>
                </div>
            </div>
            <div class="container site-footer__bottom">
                <p>&copy; <?= date('Y') ?> <?= esc($site['name']) ?>. Dibangun dengan CodeIgniter 4.</p>
            </div>
        </footer>
    </div>
</body>
</html>
