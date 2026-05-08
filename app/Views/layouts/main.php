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
                    <span class="brand__eyebrow">Website Yayasan</span>
                    <span class="brand__name"><?= esc($site['shortName']) ?></span>
                    <span class="brand__sub"><?= esc($site['name']) ?></span>
                </a>

                <?php
                $path = trim(str_replace('index.php', '', $currentUri ?? ''), '/');
                $isActive = static function (string $target) use ($path): string {
                    $target = trim($target, '/');

                    return $path === $target ? 'is-active' : '';
                };
                ?>

                <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false" data-nav-toggle>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <nav class="site-nav" aria-label="Navigasi utama" data-nav-menu>
                    <a class="<?= $isActive('/') ?>" href="<?= site_url('/') ?>">Beranda</a>
                    <a class="<?= $isActive('tentang') ?>" href="<?= site_url('tentang') ?>">Tentang</a>
                    <a class="<?= $isActive('program') ?>" href="<?= site_url('program') ?>">Program</a>
                    <a class="<?= $isActive('gallery') ?>" href="<?= site_url('gallery') ?>">Gallery</a>
                    <a class="<?= $isActive('donasi') ?>" href="<?= site_url('donasi') ?>">Donasi</a>
                    <?php if (! empty($authUser)): ?>
                        <a href="<?= site_url(($authUser['role'] ?? 'user') === 'admin' ? 'admin' : 'dashboard') ?>">Dashboard</a>
                        <a href="<?= site_url('logout') ?>">Logout</a>
                    <?php else: ?>
                        <a href="<?= site_url('login') ?>">Login</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <main>
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="site-footer">
            <div class="container site-footer__grid footer-minimal">
                <div>
                    <p class="footer-label">Yayasan</p>
                    <h2><?= esc($site['name']) ?></h2>
                    <p><?= esc($site['tagline']) ?></p>
                </div>
                <div>
                    <p class="footer-label">Rekening donasi resmi</p>
                    <?php foreach ($site['bankAccounts'] as $account): ?>
                        <p><?= esc($account['bank']) ?> <?= esc($account['number']) ?></p>
                    <?php endforeach; ?>
                    <p>a.n. <?= esc($site['bankHolder']) ?></p>
                </div>
            </div>
            <div class="container site-footer__bottom">
                <p>&copy; <?= date('Y') ?> <?= esc($site['name']) ?>. Pengurus <?= esc($site['shortName']) ?>.</p>
            </div>
        </footer>
    </div>

    <script>
        const navToggle = document.querySelector('[data-nav-toggle]');
        const navMenu = document.querySelector('[data-nav-menu]');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                const isOpen = navMenu.classList.toggle('is-open');
                navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }
    </script>
</body>
</html>
