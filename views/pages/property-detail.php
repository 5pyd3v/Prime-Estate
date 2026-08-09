<?php
/** @var array $property */
/** @var array $images */
/** @var array $features */
/** @var array $similar */
/** @var array|null $agent */
$p = $property;
view('layouts/site-header', ['title' => $title, 'description' => $description, 'ogImage' => $ogImage ?? null, 'heroPage' => $heroPage]);

$gallery = $images ? array_map(fn ($i) => media_url($i['path']), $images) : [asset('images/placeholder.svg')];
$whatsappNum = $agent['whatsapp'] ?? Settings::get('whatsapp', '');
$waMessage = 'Hello, I am interested in "' . $p['title'] . '" (' . base_url('/property/' . $p['slug']) . ')';
$statusLabels = ['available' => 'Available', 'sold' => 'Sold', 'rented' => 'Rented', 'under_offer' => 'Under Offer'];
?>
<div class="container" style="padding-top:126px;">
    <div class="breadcrumb">
        <a href="/">Home</a> <span>/</span> <a href="/properties">Properties</a> <span>/</span> <span><?= e($p['title']) ?></span>
    </div>

    <div class="detail-gallery">
        <div class="main-img" data-lightbox-trigger="0">
            <img src="<?= e($gallery[0]) ?>" alt="<?= e($p['title']) ?>">
            <?php if (count($gallery) > 1): ?><span class="view-all-btn">View all <?= count($gallery) ?> photos</span><?php endif; ?>
        </div>
        <div class="side-imgs">
            <?php for ($i = 1; $i <= 2; $i++): ?>
                <?php if (isset($gallery[$i])): ?>
                    <div data-lightbox-trigger="<?= $i ?>"><img src="<?= e($gallery[$i]) ?>" alt=""></div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <script type="application/json" id="galleryData"><?= json_encode($gallery) ?></script>

    <div class="detail-layout">
        <div>
            <div class="detail-header">
                <div>
                    <div style="display:flex;gap:8px;margin-bottom:10px;">
                        <span class="badge badge-<?= e($p['purpose']) ?>"><?= $p['purpose'] === 'sale' ? 'For Sale' : 'For Rent' ?></span>
                        <?php if ($p['is_featured']): ?><span class="badge badge-featured">Featured</span><?php endif; ?>
                        <span class="badge badge-neutral"><?= e($statusLabels[$p['status']] ?? $p['status']) ?></span>
                    </div>
                    <h1 style="font-size:28px;margin-bottom:6px;"><?= e($p['title']) ?></h1>
                    <div class="property-card-location" style="font-size:14px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        <?= e(trim(($p['address'] ?: $p['area_name']) . ($p['city_name'] ? ', ' . $p['city_name'] : ''))) ?>
                    </div>
                </div>
                <div class="detail-price"><?= format_money($p['price'], $p['currency']) ?><?php if ($p['price_label']): ?> <span style="font-size:14px;font-weight:500;color:var(--color-muted);"><?= e($p['price_label']) ?></span><?php endif; ?></div>
            </div>

            <div class="spec-strip">
                <?php if ($p['bedrooms']): ?><div class="spec-item"><span class="label">Bedrooms</span><span class="value"><?= (int) $p['bedrooms'] ?></span></div><?php endif; ?>
                <?php if ($p['bathrooms']): ?><div class="spec-item"><span class="label">Bathrooms</span><span class="value"><?= (int) $p['bathrooms'] ?></span></div><?php endif; ?>
                <?php if ($p['area_size']): ?><div class="spec-item"><span class="label">Area</span><span class="value"><?= rtrim(rtrim(number_format((float) $p['area_size'], 1), '0'), '.') ?> <?= e($p['area_unit']) ?></span></div><?php endif; ?>
                <?php if ($p['parking_spaces']): ?><div class="spec-item"><span class="label">Parking</span><span class="value"><?= (int) $p['parking_spaces'] ?></span></div><?php endif; ?>
                <?php if ($p['floors']): ?><div class="spec-item"><span class="label">Floors</span><span class="value"><?= (int) $p['floors'] ?></span></div><?php endif; ?>
                <div class="spec-item"><span class="label">Furnishing</span><span class="value"><?= e(ucfirst(str_replace('_', '-', $p['furnished_status']))) ?></span></div>
                <?php if ($p['year_built']): ?><div class="spec-item"><span class="label">Year Built</span><span class="value"><?= (int) $p['year_built'] ?></span></div><?php endif; ?>
            </div>

            <?php if ($p['description']): ?>
                <h2 style="font-size:19px;">Description</h2>
                <div style="color:#3a3a34;line-height:1.75;font-size:15px;margin-bottom:36px;"><?= nl2br(e($p['description'])) ?></div>
            <?php endif; ?>

            <?php if ($features): ?>
                <h2 style="font-size:19px;">Features & Amenities</h2>
                <div class="feature-tags" style="margin-bottom:36px;">
                    <?php foreach ($features as $f): ?>
                        <div class="feature-tag">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                            <?= e($f['name']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($p['video_url']): ?>
                <h2 style="font-size:19px;">Video Tour</h2>
                <div style="aspect-ratio:16/9;border-radius:var(--radius);overflow:hidden;margin-bottom:36px;">
                    <iframe src="<?= e($p['video_url']) ?>" style="width:100%;height:100%;border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
            <?php endif; ?>

            <?php if ($p['address'] || ($p['latitude'] && $p['longitude'])): ?>
                <h2 style="font-size:19px;">Location</h2>
                <div class="map-embed" style="margin-bottom:36px;">
                    <iframe src="https://www.google.com/maps?q=<?= urlencode($p['latitude'] && $p['longitude'] ? $p['latitude'] . ',' . $p['longitude'] : ($p['address'] . ', ' . $p['city_name'])) ?>&output=embed" loading="lazy"></iframe>
                </div>
            <?php endif; ?>
        </div>

        <aside class="contact-panel">
            <?php if ($agent): ?>
                <div class="agent-mini">
                    <img src="<?= e($agent['photo_media_id'] ? media_url((Media::find((int) $agent['photo_media_id'])['path'] ?? null)) : asset('images/placeholder.svg')) ?>" alt="">
                    <div>
                        <div style="font-weight:650;font-size:14.5px;"><?= e($agent['name']) ?></div>
                        <div style="font-size:12.5px;color:var(--color-muted);"><?= e($agent['designation'] ?? '') ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div style="font-weight:650;margin-bottom:14px;">Interested in this property?</div>
            <?php endif; ?>

            <div class="cta-row">
                <?php $callNum = $agent['phone'] ?? Settings::get('phone', ''); ?>
                <?php if ($callNum): ?><a class="btn btn-secondary" href="<?= e(tel_link($callNum)) ?>">Call</a><?php endif; ?>
                <?php if ($whatsappNum): ?><a class="btn btn-primary" href="<?= e(whatsapp_link($whatsappNum, $waMessage)) ?>" target="_blank" rel="noopener">WhatsApp</a><?php endif; ?>
            </div>

            <form data-ajax-form action="/inquiries" method="post">
                <?= Csrf::field() ?>
                <input type="hidden" name="property_id" value="<?= (int) $p['id'] ?>">
                <input type="hidden" name="agent_id" value="<?= (int) ($p['agent_id'] ?? 0) ?>">
                <input type="hidden" name="inquiry_type" value="details">
                <div class="form-group"><input class="form-control" name="name" placeholder="Your Name" required></div>
                <div class="form-group"><input class="form-control" name="phone" placeholder="Phone Number"></div>
                <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email Address"></div>
                <div class="form-group"><textarea class="form-control" name="message" placeholder="I'm interested in this property…"><?= e($waMessage) ?></textarea></div>
                <button class="btn btn-primary btn-block" type="submit">Request Details</button>
            </form>
            <form data-ajax-form action="/inquiries" method="post" style="margin-top:8px;">
                <?= Csrf::field() ?>
                <input type="hidden" name="property_id" value="<?= (int) $p['id'] ?>">
                <input type="hidden" name="agent_id" value="<?= (int) ($p['agent_id'] ?? 0) ?>">
                <input type="hidden" name="inquiry_type" value="visit">
                <input type="hidden" name="name" value="Visit Request">
                <input type="hidden" name="message" value="Requested a visit for <?= e($p['title']) ?>">
                <button class="btn btn-secondary btn-block" type="submit" onclick="this.form.name.value=prompt('Your name for the visit request:')||'Visitor'; return !!this.form.name.value;">Schedule Visit</button>
            </form>
        </aside>
    </div>

    <?php if ($similar): ?>
    <section class="section">
        <div class="section-head"><div><h2>Similar Properties</h2></div></div>
        <div class="property-grid">
            <?php foreach ($similar as $sp): view('partials/property-card', ['property' => $sp]); endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<div class="lightbox" id="lightbox">
    <button class="lightbox-close" aria-label="Close">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
    <button class="lightbox-prev" aria-label="Previous"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
    <img src="" alt="">
    <button class="lightbox-next" aria-label="Next"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
    <div class="lightbox-counter"></div>
</div>
<script src="<?= asset('js/gallery.js') ?>"></script>
<?php view('layouts/site-footer'); ?>
