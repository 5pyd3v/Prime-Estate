<?php
declare(strict_types=1);

function site_sitemap(): void
{
    header('Content-Type: application/xml; charset=utf-8');

    $urls = [
        ['loc' => '/', 'priority' => '1.0'],
        ['loc' => '/properties', 'priority' => '0.9'],
        ['loc' => '/buy', 'priority' => '0.8'],
        ['loc' => '/rent', 'priority' => '0.8'],
        ['loc' => '/projects', 'priority' => '0.8'],
        ['loc' => '/agents', 'priority' => '0.6'],
        ['loc' => '/services', 'priority' => '0.6'],
        ['loc' => '/blog', 'priority' => '0.6'],
        ['loc' => '/about-us', 'priority' => '0.5'],
        ['loc' => '/contact', 'priority' => '0.5'],
    ];

    $db = DB::connection();

    foreach ($db->query("SELECT slug, updated_at FROM properties WHERE is_published = 1")->fetchAll() as $row) {
        $urls[] = ['loc' => '/property/' . $row['slug'], 'priority' => '0.7', 'lastmod' => $row['updated_at']];
    }
    foreach ($db->query("SELECT slug, updated_at FROM projects WHERE is_published = 1")->fetchAll() as $row) {
        $urls[] = ['loc' => '/project/' . $row['slug'], 'priority' => '0.7', 'lastmod' => $row['updated_at']];
    }
    foreach ($db->query("SELECT slug FROM agents WHERE is_active = 1")->fetchAll() as $row) {
        $urls[] = ['loc' => '/agent/' . $row['slug'], 'priority' => '0.5'];
    }
    foreach ($db->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published'")->fetchAll() as $row) {
        $urls[] = ['loc' => '/blog/' . $row['slug'], 'priority' => '0.6', 'lastmod' => $row['updated_at']];
    }

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        echo '  <url>' . "\n";
        echo '    <loc>' . e(base_url($u['loc'])) . '</loc>' . "\n";
        if (!empty($u['lastmod'])) {
            echo '    <lastmod>' . date('Y-m-d', strtotime($u['lastmod'])) . '</lastmod>' . "\n";
        }
        echo '    <priority>' . $u['priority'] . '</priority>' . "\n";
        echo '  </url>' . "\n";
    }
    echo '</urlset>';
}

function site_robots(): void
{
    header('Content-Type: text/plain; charset=utf-8');
    echo "User-agent: *\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /uploads/documents/\n";
    echo "Allow: /\n\n";
    echo 'Sitemap: ' . base_url('/sitemap.xml') . "\n";
}
