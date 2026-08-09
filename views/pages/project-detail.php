<?php
/** @var array $project */
/** @var array $images */
/** @var array $amenities */
/** @var array $related */
$p = $project;
view('layouts/site-header', ['title' => $title, 'description' => $description, 'ogImage' => $ogImage ?? null, 'heroPage' => $heroPage]);
$gallery = $images ? array_map(fn ($i) => media_url($i['path']), $images) : [asset('images/placeholder.svg')];
$statusLabels = ['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'];
$logo = $p['logo_media_id'] ? media_url((Media::find((int) $p['logo_media_id'])['path'] ?? null)) : null;
$brochure = $p['brochure_media_id'] ? media_url((Media::find((int) $p['brochure_media_id'])['path'] ?? null)) : null;
?>
<div class="container" style="padding-top:126px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <a href="/projects">Projects</a> <span>/</span> <span><?= e($p['name']) ?></span></div>

    <div class="detail-gallery">
        <div class="main-img" data-lightbox-trigger="0"><img src="<?= e($gallery[0]) ?>" alt="<?= e($p['name']) ?>"><?php if (count($gallery) > 1): ?><span class="view-all-btn">View all <?= count($gallery) ?> photos</span><?php endif; ?></div>
        <div class="side-imgs">
            <?php for ($i = 1; $i <= 2; $i++): if (isset($gallery[$i])): ?><div data-lightbox-trigger="<?= $i ?>"><img src="<?= e($gallery[$i]) ?>" alt=""></div><?php endif; endfor; ?>
        </div>
    </div>
    <script type="application/json" id="galleryData"><?= json_encode($gallery) ?></script>

    <div class="detail-layout">
        <div>
            <div class="detail-header">
                <div>
                    <div style="display:flex;gap:8px;margin-bottom:10px;">
                        <span class="badge badge-neutral"><?= e($statusLabels[$p['status']] ?? $p['status']) ?></span>
                        <?php if ($p['is_featured']): ?><span class="badge badge-featured">Featured</span><?php endif; ?>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <?php if ($logo): ?><img src="<?= e($logo) ?>" alt="" style="width:44px;height:44px;border-radius:10px;object-fit:cover;"><?php endif; ?>
                        <h1 style="font-size:28px;margin:0;"><?= e($p['name']) ?></h1>
                    </div>
                    <div class="property-card-location" style="font-size:14px;margin-top:8px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        <?= e($p['location'] ?: ($p['city_name'] ?? '')) ?>
                    </div>
                </div>
                <?php if ($p['starting_price']): ?><div class="detail-price"><?= e($p['price_label'] ?: 'Starting from') ?><br><?= format_money($p['starting_price']) ?></div><?php endif; ?>
            </div>

            <div class="spec-strip">
                <?php if ($p['developer']): ?><div class="spec-item"><span class="label">Developer</span><span class="value"><?= e($p['developer']) ?></span></div><?php endif; ?>
                <div class="spec-item"><span class="label">Status</span><span class="value"><?= e($statusLabels[$p['status']] ?? '') ?></span></div>
                <?php if ($p['completion_date']): ?><div class="spec-item"><span class="label">Completion</span><span class="value"><?= date('M Y', strtotime($p['completion_date'])) ?></span></div><?php endif; ?>
            </div>

            <?php if ($p['description']): ?>
                <h2 style="font-size:19px;">About This Project</h2>
                <div style="color:#3a3a34;line-height:1.75;font-size:15px;margin-bottom:36px;"><?= nl2br(e($p['description'])) ?></div>
            <?php endif; ?>

            <?php if ($amenities): ?>
                <h2 style="font-size:19px;">Amenities</h2>
                <div class="feature-tags" style="margin-bottom:36px;">
                    <?php foreach ($amenities as $a): ?>
                        <div class="feature-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg><?= e($a) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($p['payment_plan']): ?>
                <h2 style="font-size:19px;">Payment Plan</h2>
                <div style="color:#3a3a34;line-height:1.75;font-size:15px;margin-bottom:36px;"><?= nl2br(e($p['payment_plan'])) ?></div>
            <?php endif; ?>
        </div>

        <aside class="contact-panel">
            <div style="font-weight:650;margin-bottom:14px;">Interested in <?= e($p['name']) ?>?</div>
            <?php if ($brochure): ?><a class="btn btn-secondary btn-block" style="margin-bottom:12px;" href="<?= e($brochure) ?>" target="_blank" rel="noopener">Download Brochure</a><?php endif; ?>
            <form data-ajax-form action="/inquiries" method="post">
                <?= Csrf::field() ?>
                <input type="hidden" name="project_id" value="<?= (int) $p['id'] ?>">
                <input type="hidden" name="inquiry_type" value="details">
                <div class="form-group"><input class="form-control" name="name" placeholder="Your Name" required></div>
                <div class="form-group"><input class="form-control" name="phone" placeholder="Phone Number"></div>
                <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email Address"></div>
                <div class="form-group"><textarea class="form-control" name="message" placeholder="I'm interested in this project…"></textarea></div>
                <button class="btn btn-primary btn-block" type="submit">Request Information</button>
            </form>
        </aside>
    </div>

    <?php if ($related): ?>
    <section class="section">
        <div class="section-head"><div><h2>Related Projects</h2></div></div>
        <div class="property-grid">
            <?php foreach ($related as $rp): view('partials/project-card', ['project' => $rp]); endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<div class="lightbox" id="lightbox">
    <button class="lightbox-close" aria-label="Close"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <button class="lightbox-prev" aria-label="Previous"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
    <img src="" alt="">
    <button class="lightbox-next" aria-label="Next"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
    <div class="lightbox-counter"></div>
</div>
<script src="<?= asset('js/gallery.js') ?>"></script>
<?php view('layouts/site-footer'); ?>
