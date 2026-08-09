<?php
/** @var array $section */
$type = $section['section_type'];
$heading = $section['heading'] ?? '';
$sub = $section['subheading'] ?? '';
$content = $section['content'] ?? '';
?>
<?php switch ($type):
    case 'hero': ?>
        <section class="section-tight text-center">
            <div class="container" style="max-width:760px;">
                <?php if ($heading): ?><h1 style="font-size:clamp(30px,4.4vw,46px);"><?= e($heading) ?></h1><?php endif; ?>
                <?php if ($sub): ?><p style="color:var(--color-muted);font-size:16px;"><?= e($sub) ?></p><?php endif; ?>
            </div>
        </section>
        <?php break;

    case 'text': ?>
        <section class="section-tight">
            <div class="container" style="max-width:820px;">
                <?php if ($heading): ?><h2><?= e($heading) ?></h2><?php endif; ?>
                <?php if ($content): ?><div style="color:var(--color-muted);font-size:16px;line-height:1.75;"><?= $content ?></div><?php endif; ?>
            </div>
        </section>
        <?php break;

    case 'statistics': ?>
        <section class="section-tight section-alt">
            <div class="container">
                <?php if ($heading): ?><h2 class="text-center" style="margin-bottom:40px;"><?= e($heading) ?></h2><?php endif; ?>
                <div class="stats-grid">
                    <div class="stat-block"><div class="num"><?= (int) DB::connection()->query('SELECT COUNT(*) FROM properties WHERE is_published=1')->fetchColumn() ?>+</div><div class="lbl">Properties Listed</div></div>
                    <div class="stat-block"><div class="num"><?= (int) DB::connection()->query('SELECT COUNT(*) FROM agents WHERE is_active=1')->fetchColumn() ?></div><div class="lbl">Expert Agents</div></div>
                    <div class="stat-block"><div class="num"><?= (int) DB::connection()->query('SELECT COUNT(DISTINCT city_id) FROM properties')->fetchColumn() ?></div><div class="lbl">Cities Covered</div></div>
                    <div class="stat-block"><div class="num">98%</div><div class="lbl">Client Satisfaction</div></div>
                </div>
            </div>
        </section>
        <?php break;

    case 'why-us': ?>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div><span class="eyebrow">Why Choose Us</span><h2><?= e($heading ?: 'Why Choose Us') ?></h2><?php if ($sub): ?><p><?= e($sub) ?></p><?php endif; ?></div>
                </div>
                <div class="feature-grid">
                    <?php $items = [
                        ['icon' => '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/>', 'title' => 'Verified Listings', 'desc' => 'Every property is reviewed and verified by our team before it goes live.'],
                        ['icon' => '<path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/>', 'title' => 'Local Expertise', 'desc' => 'Deep knowledge of neighborhoods across Islamabad, Lahore and Karachi.'],
                        ['icon' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>', 'title' => 'Fast Response', 'desc' => 'Our agents respond to inquiries quickly so you never miss an opportunity.'],
                        ['icon' => '<path d="M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1z"/>', 'title' => 'Transparent Pricing', 'desc' => 'No hidden fees — clear pricing and honest guidance from day one.'],
                    ]; ?>
                    <?php foreach ($items as $it): ?>
                        <div class="feature-item">
                            <div class="icon-wrap"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><?= $it['icon'] ?></svg></div>
                            <h3><?= e($it['title']) ?></h3>
                            <p><?= e($it['desc']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php break;

    case 'property-types': ?>
        <section class="section section-alt">
            <div class="container">
                <div class="section-head"><div><span class="eyebrow">Browse</span><h2><?= e($heading ?: 'Browse by Property Type') ?></h2></div></div>
                <div class="category-grid">
                    <?php foreach (PropertyType::withCounts() as $t): ?>
                        <a class="category-tile" href="/properties?type=<?= e($t['slug']) ?>">
                            <div class="icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/></svg></div>
                            <div style="font-weight:600;font-size:14px;"><?= e($t['name']) ?></div>
                            <div class="count"><?= (int) $t['property_count'] ?> listings</div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php break;

    case 'featured-properties': ?>
        <?php
        $purpose = $section['_purpose'] ?? null;
        $featured = Property::featured(6, $purpose);
        ?>
        <?php if ($featured): ?>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div><span class="eyebrow">Handpicked</span><h2><?= e($heading ?: 'Featured Properties') ?></h2><?php if ($sub): ?><p><?= e($sub) ?></p><?php endif; ?></div>
                    <a class="btn btn-secondary" href="/properties<?= $purpose ? '?purpose=' . e($purpose) : '' ?>">View All</a>
                </div>
                <div class="property-grid">
                    <?php foreach ($featured as $property): view('partials/property-card', ['property' => $property]); endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php break;

    case 'services': ?>
        <?php $services = Service::published(); ?>
        <?php if ($services): ?>
        <section class="section section-alt">
            <div class="container">
                <div class="section-head"><div><span class="eyebrow">Services</span><h2><?= e($heading ?: 'What We Offer') ?></h2></div></div>
                <div class="feature-grid">
                    <?php foreach ($services as $s): ?>
                        <div class="feature-item">
                            <div class="icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/></svg></div>
                            <h3><a href="/services#<?= e($s['slug']) ?>" style="color:inherit;"><?= e($s['title']) ?></a></h3>
                            <p><?= e($s['short_description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php break;

    case 'testimonials': ?>
        <?php $testimonials = Testimonial::published(6); ?>
        <?php if ($testimonials): ?>
        <section class="section">
            <div class="container">
                <div class="section-head"><div><span class="eyebrow">Testimonials</span><h2><?= e($heading ?: 'What Our Clients Say') ?></h2></div></div>
                <div class="testimonial-grid">
                    <?php foreach ($testimonials as $t): view('partials/testimonial-card', ['testimonial' => $t]); endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php break;

    case 'team': ?>
        <?php $agents = Agent::active(); ?>
        <?php if ($agents): ?>
        <section class="section section-alt">
            <div class="container">
                <div class="section-head"><div><span class="eyebrow">Our Team</span><h2><?= e($heading ?: 'Meet Our Team') ?></h2></div></div>
                <div class="agent-grid">
                    <?php foreach ($agents as $a): view('partials/agent-card', ['agent' => $a]); endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php break;

    case 'cta': ?>
        <section class="section-tight">
            <div class="container">
                <div class="cta-band">
                    <h2><?= e($heading ?: 'Ready to get started?') ?></h2>
                    <?php if ($sub): ?><p><?= e($sub) ?></p><?php endif; ?>
                    <a class="btn btn-outline" style="background:#fff;color:var(--color-primary);border-color:#fff;" href="/contact">Contact Us</a>
                </div>
            </div>
        </section>
        <?php break;

    case 'faq': ?>
        <section class="section-tight">
            <div class="container" style="max-width:760px;">
                <?php if ($heading): ?><h2 class="text-center" style="margin-bottom:30px;"><?= e($heading) ?></h2><?php endif; ?>
                <?php $faqs = [
                    ['q' => 'How do I schedule a property visit?', 'a' => 'Click "Schedule Visit" on any property page or contact the listing agent directly via WhatsApp or phone.'],
                    ['q' => 'Are your listings verified?', 'a' => 'Yes, every property is reviewed by our team before publishing to ensure accuracy.'],
                    ['q' => 'Do you charge buyers a commission?', 'a' => 'Our fee structure varies by service — contact us for full details specific to your transaction.'],
                ]; ?>
                <?php foreach ($faqs as $f): ?>
                    <div class="faq-item">
                        <button class="faq-question"><?= e($f['q']) ?> <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transition:transform .2s;"><path d="M6 9l6 6 6-6"/></svg></button>
                        <div class="faq-answer"><?= e($f['a']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php break;

    case 'map': ?>
        <?php $address = Settings::get('address', ''); ?>
        <?php if ($address): ?>
        <section class="section-tight">
            <div class="container">
                <div class="map-embed"><iframe src="https://www.google.com/maps?q=<?= urlencode($address) ?>&output=embed" loading="lazy"></iframe></div>
            </div>
        </section>
        <?php endif; ?>
        <?php break;
endswitch; ?>
