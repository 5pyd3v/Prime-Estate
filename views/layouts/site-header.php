<?php
/** @var string $title */
/** @var string|null $description */
/** @var bool $heroPage */
/** @var string|null $ogImage */
$siteName = Settings::get('site_name', 'Real Estate');
$logo = Settings::media('logo_media_id');
$favicon = Settings::media('favicon_media_id');
$phone = Settings::get('phone', '');
$whatsapp = Settings::get('whatsapp', '');
$heroPage = $heroPage ?? false;
$description = $description ?? Settings::get('default_seo_description', '');
$navItems = Menu::forLocation('header');
$currentPath = current_path();

$primary = Settings::get('primary_color', '#16302B');
$secondary = Settings::get('secondary_color', '#B08D57');
$accent = Settings::get('accent_color', '#E8873A');
$bg = Settings::get('bg_color', '#FAF9F6');
$text = Settings::get('text_color', '#1A1A1A');
$radius = Settings::get('border_radius', '14');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?><?= $title !== $siteName ? ' · ' . e($siteName) : '' ?></title>
<meta name="description" content="<?= e(truncate($description, 300)) ?>">
<link rel="canonical" href="<?= e(base_url($currentPath)) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e(truncate($description, 300)) ?>">
<meta property="og:image" content="<?= e($ogImage ?? $logo) ?>">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= e($favicon ?: asset('images/placeholder.svg')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap">
<link rel="stylesheet" href="<?= asset('css/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/components.css') ?>">
<style>
    :root {
        --color-primary: <?= e($primary) ?>;
        --color-primary-dark: color-mix(in srgb, <?= e($primary) ?> 82%, black);
        --color-secondary: <?= e($secondary) ?>;
        --color-accent: <?= e($accent) ?>;
        --color-bg: <?= e($bg) ?>;
        --color-text: <?= e($text) ?>;
        --radius: <?= (int) $radius ?>px;
    }
</style>
</head>
<body>

<header class="site-header <?= $heroPage ? '' : 'nav-solid' ?>">
    <nav class="pill-nav">
        <a class="pill-nav-logo" href="/">
            <?php if ($logo): ?><img src="<?= e($logo) ?>" alt="<?= e($siteName) ?>"><?php else: ?><span><?= e($siteName) ?></span><?php endif; ?>
        </a>
        <ul class="pill-nav-links">
            <?php foreach ($navItems as $item): ?>
                <li><a href="<?= e($item['url']) ?>" target="<?= e($item['target']) ?>" class="<?= $currentPath === $item['url'] ? 'active' : '' ?>"><?= e($item['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="pill-nav-cta">
            <?php if ($phone): ?>
            <a class="nav-phone-link" href="<?= e(tel_link($phone)) ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3.1 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7c.1.9.3 1.8.6 2.7a2 2 0 01-.5 2.1L8 9.7a16 16 0 006 6l1.2-1.2a2 2 0 012.1-.5c.9.3 1.8.5 2.7.6a2 2 0 011.7 2z"/></svg>
                <?= e($phone) ?>
            </a>
            <?php endif; ?>
            <a class="btn btn-primary" href="<?= e(Settings::get('hero_cta_url', '/properties')) ?>">Browse Properties</a>
        </div>
        <button class="pill-nav-hamburger" id="navHamburger" aria-label="Open menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>
</header>

<div class="mobile-nav-panel" id="mobileNavPanel">
    <div class="mobile-nav-head">
        <?php if ($logo): ?><img src="<?= e($logo) ?>" alt="" style="height:28px;"><?php else: ?><strong><?= e($siteName) ?></strong><?php endif; ?>
        <button id="mobileNavClose" aria-label="Close menu" style="width:36px;height:36px;border-radius:50%;border:1px solid var(--color-border);background:none;display:flex;align-items:center;justify-content:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
    <ul class="mobile-nav-links">
        <?php foreach ($navItems as $item): ?>
            <li><a href="<?= e($item['url']) ?>"><?= e($item['label']) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="mobile-nav-foot">
        <?php if ($phone): ?><a class="btn btn-secondary btn-block" href="<?= e(tel_link($phone)) ?>">Call <?= e($phone) ?></a><?php endif; ?>
        <a class="btn btn-primary btn-block" href="<?= e(Settings::get('hero_cta_url', '/properties')) ?>">Browse Properties</a>
    </div>
</div>
