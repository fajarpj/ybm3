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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

        <?php if (($authUser['role'] ?? 'guest') !== 'admin' && ! in_array($path, ['donasi', 'login', 'register'], true)): ?>
            <a class="donate-float" href="<?= site_url('donasi') ?>" aria-label="Buka halaman donasi">
                <span>Donasi Sekarang</span>
            </a>
        <?php endif; ?>

        <?php if (($authUser['role'] ?? 'guest') !== 'admin'): ?>
            <a class="whatsapp-float" href="https://wa.me/6285353400700" target="_blank" rel="noopener noreferrer" aria-label="Hubungi WhatsApp YB3M Peduli">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M19.05 4.91A9.82 9.82 0 0 0 12.03 2C6.56 2 2.1 6.45 2.1 11.93c0 1.75.46 3.46 1.33 4.97L2 22l5.24-1.37a9.9 9.9 0 0 0 4.78 1.22h.01c5.47 0 9.93-4.45 9.93-9.93a9.84 9.84 0 0 0-2.91-7.01Zm-7.02 15.26h-.01a8.2 8.2 0 0 1-4.17-1.14l-.3-.18-3.11.81.83-3.03-.2-.31a8.21 8.21 0 0 1-1.26-4.39c0-4.53 3.69-8.22 8.23-8.22a8.17 8.17 0 0 1 5.82 2.41 8.16 8.16 0 0 1 2.41 5.81c0 4.54-3.69 8.24-8.24 8.24Zm4.51-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.78.96-.14.16-.29.18-.54.06-.25-.12-1.06-.39-2.02-1.26-.74-.66-1.25-1.48-1.4-1.73-.15-.24-.01-.37.11-.49.11-.11.25-.29.37-.43.12-.15.16-.25.24-.41.08-.17.04-.31-.02-.43-.07-.12-.56-1.35-.77-1.84-.2-.48-.4-.42-.56-.43h-.47c-.16 0-.43.06-.65.31-.23.24-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.64 4.2 3.71.59.26 1.05.42 1.41.54.59.19 1.12.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.28Z"/>
                </svg>
            </a>
        <?php endif; ?>

        <footer class="site-footer">
            <div class="container site-footer__grid footer-minimal">
                <div>
                    <p class="footer-label">Yayasan</p>
                    <h2><?= esc($site['name']) ?></h2>
                    <p><?= esc($site['tagline']) ?></p>
                    <div class="footer-links">
                        <a href="<?= site_url('kebijakan-privasi') ?>">Kebijakan Privasi</a>
                        <a href="<?= site_url('syarat-ketentuan') ?>">Syarat & Ketentuan</a>
                        <a href="<?= site_url('kebijakan-pengembalian-dana') ?>">Kebijakan Pengembalian Dana</a>
                    </div>
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
