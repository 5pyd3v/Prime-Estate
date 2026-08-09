<?php
/** @var array $services */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
$icons = [
    'home' => '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/>',
    'key' => '<circle cx="8" cy="15" r="4"/><path d="M10.5 12.5L21 2M18 5l3 3M15 8l2 2"/>',
    'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>',
    'chart' => '<path d="M3 3v18h18"/><path d="M7 15l4-6 4 3 5-8"/>',
    'building' => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>',
    'calculator' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M8 6h8M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>',
];
?>
<div class="container" style="padding-top:130px;padding-bottom:20px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Services</span></div>
    <div class="section-head"><div><span class="eyebrow">What We Offer</span><h1 style="font-size:30px;">Our Services</h1></div></div>
</div>
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="feature-grid">
            <?php foreach ($services as $s): ?>
                <div class="feature-item" id="<?= e($s['slug']) ?>">
                    <div class="icon-wrap"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><?= $icons[$s['icon']] ?? $icons['home'] ?></svg></div>
                    <h3><?= e($s['title']) ?></h3>
                    <p><?= e($s['short_description']) ?></p>
                    <?php if ($s['description']): ?><p style="font-size:13.5px;margin-top:6px;"><?= e($s['description']) ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section-tight">
    <div class="container">
        <div class="cta-band">
            <h2>Ready to Get Started?</h2>
            <p>Speak with our team today and let us help with your next property move.</p>
            <a class="btn btn-outline" style="background:#fff;color:var(--color-primary);border-color:#fff;" href="/contact">Contact Us</a>
        </div>
    </div>
</section>
<?php view('layouts/site-footer'); ?>
