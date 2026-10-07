<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= htmlspecialchars($url['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8') ?></loc>
        <lastmod><?= htmlspecialchars($date, ENT_XML1 | ENT_COMPAT, 'UTF-8') ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority><?= htmlspecialchars($url['priority'], ENT_XML1 | ENT_COMPAT, 'UTF-8') ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
