<?php
/** @var array $sections */
/** @var string $purpose */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);

$heroSection = null;
$rest = [];
foreach ($sections as $s) {
    if ($s['section_type'] === 'hero' && $heroSection === null) {
        $heroSection = $s;
    } else {
        $rest[] = $s;
    }
}
$heroImage = Settings::media('hero_image_' . ($purpose === 'sale' ? '1' : '2')) ?: Settings::media('hero_image_1');
?>
<section class="hero" style="min-height:64vh;">
    <div class="hero-slides">
        <div class="hero-slide active" style="background-image:url('<?= e($heroImage ?: asset('images/placeholder.svg')) ?>');"></div>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <h1><?= e($heroSection['heading'] ?? '') ?></h1>
        <?php if (!empty($heroSection['subheading'])): ?><p class="lead"><?= e($heroSection['subheading']) ?></p><?php endif; ?>
        <?php view('partials/search-form-hero', ['purpose' => $purpose]); ?>
    </div>
</section>

<?php foreach ($rest as $section): ?>
    <?php view('partials/render-section', ['section' => $section]); ?>
<?php endforeach; ?>

<?php view('layouts/site-footer'); ?>
