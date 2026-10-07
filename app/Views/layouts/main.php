<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | <?= esc($site['name']) ?></title>
    <?php
    $metaTitle       = ($title ?? 'Beranda') . ' | ' . $site['name'];
    $metaDescription = $description ?? $site['tagline'];
    $metaImage       = base_url('assets/images/og-ybm3-logo.png');
    $metaUrl         = current_url();
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'NGO',
        'name' => $site['name'],
        'alternateName' => $site['shortName'],
        'url' => site_url('/'),
        'logo' => $metaImage,
        'description' => $site['tagline'],
        'email' => $site['email'],
        'telephone' => $site['phone'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $site['address'],
            'addressCountry' => 'ID',
        ],
        'sameAs' => array_values(array_filter(array_column($site['socials'] ?? [], 'url'))),
    ];
    ?>
    <meta name="description" content="<?= esc($metaDescription) ?>">
    <link rel="canonical" href="<?= esc($metaUrl, 'attr') ?>">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= esc($site['name'], 'attr') ?>">
    <meta property="og:title" content="<?= esc($metaTitle, 'attr') ?>">
    <meta property="og:description" content="<?= esc($metaDescription, 'attr') ?>">
    <meta property="og:url" content="<?= esc($metaUrl, 'attr') ?>">
    <meta property="og:image" content="<?= esc($metaImage, 'attr') ?>">
    <meta property="og:image:secure_url" content="<?= esc($metaImage, 'attr') ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= esc($metaTitle, 'attr') ?>">
    <meta name="twitter:description" content="<?= esc($metaDescription, 'attr') ?>">
    <meta name="twitter:image" content="<?= esc($metaImage, 'attr') ?>">
    <script type="application/ld+json"><?= json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php $siteCssVersion = is_file(FCPATH . 'assets/css/site.css') ? filemtime(FCPATH . 'assets/css/site.css') : time(); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/site.css?v=' . $siteCssVersion) ?>">
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
            <a class="whatsapp-float" href="https://wa.me/6285712759526" target="_blank" rel="noopener noreferrer" aria-label="Hubungi WhatsApp YBM3">
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
                <div>
                    <p class="footer-label">Sosial Media</p>
                    <?php
                    $socialIcons = [
                        'Facebook' => '<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M14.2 8.7h2.1V5.3c-.4-.1-1.6-.2-3-.2-3 0-5 1.8-5 5.1v2.9H5v3.8h3.3V24h4v-7.1h3.3l.5-3.8h-3.8v-2.5c0-1.1.3-1.9 1.9-1.9Z"/></svg>',
                        'Instagram' => '<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7.3 2h9.4A5.3 5.3 0 0 1 22 7.3v9.4a5.3 5.3 0 0 1-5.3 5.3H7.3A5.3 5.3 0 0 1 2 16.7V7.3A5.3 5.3 0 0 1 7.3 2Zm0 2A3.3 3.3 0 0 0 4 7.3v9.4A3.3 3.3 0 0 0 7.3 20h9.4a3.3 3.3 0 0 0 3.3-3.3V7.3A3.3 3.3 0 0 0 16.7 4H7.3Zm4.7 3.7A4.3 4.3 0 1 1 7.7 12 4.3 4.3 0 0 1 12 7.7Zm0 2A2.3 2.3 0 1 0 14.3 12 2.3 2.3 0 0 0 12 9.7Zm4.6-3.1a1 1 0 1 1-1 1 1 1 0 0 1 1-1Z"/></svg>',
                        'YouTube' => '<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.7 4.6 12 4.6 12 4.6s-5.7 0-7.5.5a3 3 0 0 0-2.1 2.1A31.2 31.2 0 0 0 1.9 12c0 1.6.1 3.2.5 4.8a3 3 0 0 0 2.1 2.1c1.8.5 7.5.5 7.5.5s5.7 0 7.5-.5a3 3 0 0 0 2.1-2.1c.4-1.6.5-3.2.5-4.8s-.1-3.2-.5-4.8ZM10 15.3V8.7l5.7 3.3L10 15.3Z"/></svg>',
                    ];
                    ?>
                    <div class="footer-socials">
                        <?php foreach ($site['socials'] as $social): ?>
                            <a href="<?= esc($social['url']) ?>" target="_blank" rel="noopener noreferrer">
                                <span class="footer-socials__icon">
                                    <?= $socialIcons[$social['label']] ?? '' ?>
                                </span>
                                <span class="footer-socials__text">
                                    <small><?= esc($social['label']) ?></small>
                                    <strong><?= esc($social['value']) ?></strong>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
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
