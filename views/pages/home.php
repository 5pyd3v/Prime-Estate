<?php
/** @var array|null $heroSection */
/** @var array $sections */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);

$heading = $heroSection['heading'] ?? Settings::get('hero_heading', "Find a Place You'll Love to Call Home");
$sub = $heroSection['subheading'] ?? Settings::get('hero_subheading', '');
$ctaText = Settings::get('hero_cta_text', 'Browse Properties');
$ctaUrl = Settings::get('hero_cta_url', '/properties');
$cta2Text = Settings::get('hero_secondary_cta_text', '');
$cta2Url = Settings::get('hero_secondary_cta_url', '/contact');
$overlay = (float) Settings::get('hero_overlay_opacity', 0.45);

$heroImages = array_filter([
    Settings::media('hero_image_1'),
    Settings::media('hero_image_2'),
    Settings::media('hero_image_3'),
]);
if (!$heroImages) {
    $heroImages = [asset('images/placeholder.svg')];
}
?>
<section class="hero">
    <div class="hero-slides">
        <?php foreach ($heroImages as $i => $img): ?>
            <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>" style="background-image:url('<?= e($img) ?>');"></div>
        <?php endforeach; ?>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <div class="hero-eyebrow">Trusted Real Estate Across Pakistan</div>
        <h1><?= e($heading) ?></h1>
        <?php if ($sub): ?><p class="lead"><?= e($sub) ?></p><?php endif; ?>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="<?= e($ctaUrl) ?>"><?= e($ctaText) ?></a>
            <?php if ($cta2Text): ?><a class="btn btn-outline" href="<?= e($cta2Url) ?>"><?= e($cta2Text) ?></a><?php endif; ?>
        </div>
        <?php view('partials/search-form-hero', ['purpose' => 'sale']); ?>
    </div>
</section>

<?php foreach ($sections as $section): ?>
    <?php view('partials/render-section', ['section' => $section]); ?>
<?php endforeach; ?>

<?php view('layouts/site-footer'); ?>
