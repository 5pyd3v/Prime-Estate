<?php
declare(strict_types=1);

function site_home(): void
{
    $page = Page::bySlug('home');
    $sections = $page ? PageSection::forPage((int) $page['id']) : [];

    $heroSection = null;
    $otherSections = [];
    foreach ($sections as $s) {
        if ($s['section_type'] === 'hero' && $heroSection === null) {
            $heroSection = $s;
        } else {
            $otherSections[] = $s;
        }
    }

    view('pages/home', [
        'title' => Settings::get('default_seo_title', Settings::get('site_name', '')),
        'description' => Settings::get('default_seo_description', ''),
        'heroPage' => true,
        'heroSection' => $heroSection,
        'sections' => $otherSections,
    ]);
}
