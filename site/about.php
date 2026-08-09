<?php
declare(strict_types=1);

function site_about(): void
{
    $page = Page::bySlug('about-us');
    $sections = $page ? PageSection::forPage((int) $page['id']) : [];

    view('pages/about', [
        'title' => $page['seo_title'] ?? 'About Us',
        'description' => $page['seo_description'] ?? '',
        'heroPage' => false,
        'sections' => $sections,
    ]);
}
