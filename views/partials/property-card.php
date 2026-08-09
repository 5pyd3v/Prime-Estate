<?php
/** @var array $property */
$p = $property;
$url = '/property/' . $p['slug'];
?>
<article class="property-card">
    <a href="<?= e($url) ?>" class="property-card-media">
        <img src="<?= e(media_url($p['primary_image'] ?? null)) ?>" alt="<?= e($p['title']) ?>" loading="lazy">
        <div class="property-card-badges">
            <?php if (!empty($p['is_featured'])): ?><span class="badge badge-featured">Featured</span><?php endif; ?>
            <span class="badge badge-<?= e($p['purpose']) ?>"><?= $p['purpose'] === 'sale' ? 'For Sale' : 'For Rent' ?></span>
            <?php if (in_array($p['status'], ['sold', 'rented'], true)): ?><span class="badge badge-neutral"><?= e(ucfirst($p['status'])) ?></span><?php endif; ?>
        </div>
        <button class="fav-btn" data-property-id="<?= (int) $p['id'] ?>" aria-label="Save to favorites">
            <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.6-10-9.1C.6 8.2 2.4 4.5 6 4c2.2-.3 4 .8 6 3 2-2.2 3.8-3.3 6-3 3.6.5 5.4 4.2 4 7.9C19.5 16.4 12 21 12 21z"/></svg>
        </button>
    </a>
    <div class="property-card-body">
        <div class="property-card-price"><?= format_money($p['price'], $p['currency'] ?? 'PKR') ?><?php if (!empty($p['price_label'])): ?> <span><?= e($p['price_label']) ?></span><?php endif; ?></div>
        <h3 class="property-card-title"><a href="<?= e($url) ?>"><?= e($p['title']) ?></a></h3>
        <div class="property-card-location">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
            <?= e(trim(($p['area_name'] ?? '') . (!empty($p['area_name']) && !empty($p['city_name']) ? ', ' : '') . ($p['city_name'] ?? ''))) ?: '&mdash;' ?>
        </div>
        <div class="property-card-specs">
            <?php if (!empty($p['bedrooms'])): ?><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 18v-6a2 2 0 012-2h16a2 2 0 012 2v6"/><path d="M2 18v2M22 18v2M4 10V7a2 2 0 012-2h3a2 2 0 012 2v3"/></svg> <?= (int) $p['bedrooms'] ?> Beds</span><?php endif; ?>
            <?php if (!empty($p['bathrooms'])): ?><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12h16M6 12V5a2 2 0 012-2h1v3"/><path d="M5 12v4a4 4 0 004 4h6a4 4 0 004-4v-4"/></svg> <?= (int) $p['bathrooms'] ?> Baths</span><?php endif; ?>
            <?php if (!empty($p['area_size'])): ?><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/></svg> <?= rtrim(rtrim(number_format((float) $p['area_size'], 1), '0'), '.') ?> <?= e($p['area_unit'] ?? '') ?></span><?php endif; ?>
        </div>
    </div>
</article>
