<?php
/** @var string $title */
/** @var string $active */
/** @var string $content */
$user = Auth::user();
$siteName = Settings::get('site_name', 'Real Estate CMS');
$logo = Settings::media('logo_media_id');

$navGroups = [
    'Overview' => [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => 'grid'],
    ],
    'Listings' => [
        ['key' => 'properties', 'label' => 'Properties', 'url' => '/admin/properties', 'icon' => 'home'],
        ['key' => 'property-types', 'label' => 'Property Types', 'url' => '/admin/property-types', 'icon' => 'layers'],
        ['key' => 'features', 'label' => 'Features', 'url' => '/admin/features', 'icon' => 'check-square'],
        ['key' => 'cities', 'label' => 'Cities & Areas', 'url' => '/admin/cities', 'icon' => 'map-pin'],
        ['key' => 'projects', 'label' => 'Projects', 'url' => '/admin/projects', 'icon' => 'building'],
    ],
    'People' => [
        ['key' => 'agents', 'label' => 'Agents', 'url' => '/admin/agents', 'icon' => 'user'],
        ['key' => 'users', 'label' => 'Users', 'url' => '/admin/users', 'icon' => 'users'],
    ],
    'Content' => [
        ['key' => 'services', 'label' => 'Services', 'url' => '/admin/services', 'icon' => 'briefcase'],
        ['key' => 'testimonials', 'label' => 'Testimonials', 'url' => '/admin/testimonials', 'icon' => 'star'],
        ['key' => 'blog', 'label' => 'Blog', 'url' => '/admin/blog', 'icon' => 'file-text'],
        ['key' => 'pages', 'label' => 'Pages', 'url' => '/admin/pages', 'icon' => 'layout'],
        ['key' => 'menus', 'label' => 'Menus', 'url' => '/admin/menus', 'icon' => 'menu'],
        ['key' => 'media', 'label' => 'Media Library', 'url' => '/admin/media', 'icon' => 'image'],
    ],
    'Leads' => [
        ['key' => 'inquiries', 'label' => 'Inquiries', 'url' => '/admin/inquiries', 'icon' => 'inbox'],
        ['key' => 'messages', 'label' => 'Contact Messages', 'url' => '/admin/messages', 'icon' => 'mail'],
    ],
    'System' => [
        ['key' => 'settings', 'label' => 'Settings', 'url' => '/admin/settings', 'icon' => 'settings'],
    ],
];

$icons = [
    'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
    'home' => '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/>',
    'layers' => '<path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M3 13l9 5 9-5"/>',
    'check-square' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 12l3 3 5-6"/>',
    'map-pin' => '<path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/>',
    'building' => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>',
    'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>',
    'users' => '<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-5.5 7-5.5s7 2 7 5.5"/><path d="M16 4.5a3.3 3.3 0 010 6.5M21 19.5c0-2.8-2-4.5-4.5-5"/>',
    'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>',
    'star' => '<path d="M12 3l2.6 5.9 6.4.6-4.8 4.2 1.5 6.3L12 16.9 6.3 20l1.5-6.3-4.8-4.2 6.4-.6z"/>',
    'file-text' => '<path d="M6 2h9l5 5v15H6z"/><path d="M9 13h6M9 17h6M9 9h2"/>',
    'layout' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
    'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
    'image' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="M21 15l-5-5-4 4-3-3-5 5"/>',
    'inbox' => '<path d="M4 4h16l-1 12H5z"/><path d="M4 16l3-6h10l3 6"/>',
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
    'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19 12a7 7 0 00-.2-1.6l2-1.5-2-3.4-2.3.9a7 7 0 00-2.8-1.6L13 2h-4l-.7 2.8a7 7 0 00-2.8 1.6l-2.3-.9-2 3.4 2 1.5A7 7 0 005 12c0 .5.1 1.1.2 1.6l-2 1.5 2 3.4 2.3-.9a7 7 0 002.8 1.6L9 22h4l.7-2.8a7 7 0 002.8-1.6l2.3.9 2-3.4-2-1.5c.1-.5.2-1.1.2-1.6z"/>',
];
function admin_icon(array $icons, string $key): string
{
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . ($icons[$key] ?? $icons['grid']) . '</svg>';
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> · <?= e($siteName) ?> Admin</title>
<link rel="icon" href="<?= e(Settings::media('favicon_media_id') ?: asset('images/placeholder.svg')) ?>">
<link rel="stylesheet" href="<?= asset('css/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin-body">
<input type="hidden" id="csrfToken" value="<?= e(Csrf::token()) ?>">
<div class="admin-shell" id="adminShell">
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <?php if ($logo): ?><img src="<?= e($logo) ?>" alt=""><?php endif; ?>
            <span class="brand-text"><?= e($siteName) ?></span>
        </div>
        <nav class="sidebar-nav">
            <?php foreach ($navGroups as $group => $items): ?>
                <div class="sidebar-section-title"><?= e($group) ?></div>
                <?php foreach ($items as $item): ?>
                    <a class="sidebar-link <?= ($active ?? '') === $item['key'] ? 'active' : '' ?>" href="<?= e($item['url']) ?>">
                        <?= admin_icon($icons, $item['icon']) ?>
                        <span class="sidebar-label"><?= e($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="mobile-sidebar-toggle" id="mobileSidebarToggle" aria-label="Toggle menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Collapse sidebar">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="topbar-title"><?= e($title) ?></div>
            </div>
            <div class="topbar-right">
                <a class="view-site-link" href="/" target="_blank" rel="noopener">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><path d="M15 3h6v6"/><path d="M10 14L21 3"/></svg>
                    View Site
                </a>
                <div class="topbar-user">
                    <div class="user-avatar"><?= e(strtoupper(substr($user['name'] ?? '?', 0, 1))) ?></div>
                    <div>
                        <div style="font-weight:600;"><?= e($user['name'] ?? '') ?></div>
                        <div style="color:var(--admin-muted);font-size:11.5px;text-transform:capitalize;"><?= e(str_replace('_', ' ', $user['role'] ?? '')) ?></div>
                    </div>
                </div>
                <a href="/admin/logout" class="icon-btn" title="Logout">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                </a>
            </div>
        </header>

        <main class="admin-content">
            <?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
            <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</div>

<div class="toast-stack" id="toastStack"></div>

<div class="modal-backdrop" id="mediaPickerModal">
    <div class="modal-box modal-lg">
        <div class="modal-head">
            <h3>Select Media</h3>
            <button type="button" class="modal-close" data-modal-close aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="dropzone" id="mediaDropzone" style="margin-bottom:16px;">
                <p style="margin:0 0 8px;">Drag & drop an image here, or</p>
                <input type="file" id="mediaUploadInput" accept="image/jpeg,image/png,image/webp" style="display:none;">
                <button type="button" class="btn btn-secondary btn-sm" id="mediaUploadBtn">Upload New File</button>
            </div>
            <input type="text" class="form-control" id="mediaSearchInput" placeholder="Search media…" style="margin-bottom:14px;">
            <div class="media-grid" id="mediaGrid"></div>
        </div>
    </div>
</div>

<script src="<?= asset('js/toasts.js') ?>"></script>
<script src="<?= asset('js/admin.js') ?>"></script>
<script src="<?= asset('js/media-picker.js') ?>"></script>
</body>
</html>
