<?php
$siteName = Settings::get('site_name', 'Real Estate');
$logo = Settings::media('logo_media_id');
$phone = Settings::get('phone', '');
$whatsapp = Settings::get('whatsapp', '');
$email = Settings::get('email', '');
$address = Settings::get('address', '');
$footerDesc = Settings::get('footer_description', '');
$copyright = str_replace('{year}', date('Y'), Settings::get('footer_copyright', '© {year} ' . $siteName));
$footerLinks = Menu::forLocation('footer');
$types = PropertyType::active();
$socials = [
    'facebook_url' => 'facebook', 'instagram_url' => 'instagram', 'linkedin_url' => 'linkedin', 'youtube_url' => 'youtube', 'tiktok_url' => 'tiktok',
];
$socialIcons = [
    'facebook' => '<path d="M15 4h-2a4 4 0 00-4 4v2H7v3h2v7h3v-7h2.5l.5-3H12V8a1 1 0 011-1h2z"/>',
    'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/>',
    'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 11v5M8 8v.01M12 16v-3a2 2 0 014 0v3M12 16v-5"/>',
    'youtube' => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="M10 9l5 3-5 3z"/>',
    'tiktok' => '<path d="M9 12a4 4 0 104 4V4a5 5 0 005 5"/>',
];
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <?php if ($logo): ?><img src="<?= e($logo) ?>" alt=""><?php endif; ?>
                    <span><?= e($siteName) ?></span>
                </div>
                <p class="footer-desc"><?= e($footerDesc) ?></p>
                <div class="footer-social">
                    <?php foreach ($socials as $key => $slug): $url = Settings::get($key, ''); if (!$url) continue; ?>
                        <a href="<?= e($url) ?>" target="_blank" rel="noopener" aria-label="<?= e($slug) ?>">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><?= $socialIcons[$slug] ?></svg>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <ul>
                    <?php foreach ($footerLinks as $link): ?>
                        <li><a href="<?= e($link['url']) ?>"><?= e($link['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Property Types</h4>
                <ul>
                    <?php foreach (array_slice($types, 0, 6) as $t): ?>
                        <li><a href="/properties?type=<?= e($t['slug']) ?>"><?= e($t['name']) ?>s</a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <?php if ($address): ?><li><?= e($address) ?></li><?php endif; ?>
                    <?php if ($phone): ?><li><a href="<?= e(tel_link($phone)) ?>"><?= e($phone) ?></a></li><?php endif; ?>
                    <?php if ($email): ?><li><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></li><?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span><?= e($copyright) ?></span>
            <span>Built with Prime Estates CMS</span>
        </div>
    </div>
</footer>

<?php if ($whatsapp): ?>
<a class="whatsapp-float" href="<?= e(whatsapp_link($whatsapp, Settings::get('whatsapp_default_message', 'Hello, I am interested in your properties.'))) ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.79.47 3.47 1.29 4.93L2 22l5.28-1.38a9.9 9.9 0 004.76 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.51 2 12.04 2zm5.8 14a1.6 1.6 0 01-1.13.8c-.3.06-.68.11-2-.43-1.68-.7-2.78-2.38-2.86-2.5-.08-.11-.68-.9-.68-1.72s.42-1.22.58-1.38a.6.6 0 01.43-.2h.3c.1 0 .23 0 .35.27.13.3.44 1.05.48 1.13.04.08.06.18.01.29-.05.11-.08.18-.16.27-.08.1-.17.22-.24.29-.08.08-.16.17-.07.33.09.16.4.66.86 1.07.6.53 1.1.7 1.26.78.16.08.26.07.35-.04.1-.1.4-.47.5-.63.1-.16.2-.13.34-.08.14.05.9.42 1.05.5.16.08.26.12.3.18.03.08.03.42-.1.82z"/></svg>
</a>
<?php endif; ?>

<div class="toast-stack" id="toastStack"></div>
<script src="<?= asset('js/toasts.js') ?>"></script>
<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
