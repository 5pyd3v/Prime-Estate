<?php
/** @var array $project */
$p = $project;
$img = Project::images((int) $p['id'])[0]['path'] ?? null;
$statusLabels = ['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'];
?>
<article class="property-card">
    <a href="/project/<?= e($p['slug']) ?>" class="property-card-media">
        <img src="<?= e(media_url($img)) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
        <div class="property-card-badges">
            <?php if (!empty($p['is_featured'])): ?><span class="badge badge-featured">Featured</span><?php endif; ?>
            <span class="badge badge-neutral"><?= e($statusLabels[$p['status']] ?? $p['status']) ?></span>
        </div>
    </a>
    <div class="property-card-body">
        <?php if (!empty($p['starting_price'])): ?><div class="property-card-price"><?= e($p['price_label'] ?: 'Starting from') ?> <?= format_money($p['starting_price']) ?></div><?php endif; ?>
        <h3 class="property-card-title"><a href="/project/<?= e($p['slug']) ?>"><?= e($p['name']) ?></a></h3>
        <div class="property-card-location">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
            <?= e($p['location'] ?: ($p['city_name'] ?? '')) ?>
        </div>
        <?php if (!empty($p['developer'])): ?><div style="font-size:12.5px;color:var(--color-muted);">By <?= e($p['developer']) ?></div><?php endif; ?>
    </div>
</article>
