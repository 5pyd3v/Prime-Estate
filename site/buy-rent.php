<?php
declare(strict_types=1);

function site_buy_rent_page(string $slug, string $purpose): void
{
    $page = Page::bySlug($slug);
    $sections = $page ? PageSection::forPage((int) $page['id']) : [];

    $sections = array_map(function ($s) use ($purpose) {
        if ($s['section_type'] === 'featured-properties') {
            $s['_purpose'] = $purpose;
        }
        return $s;
    }, $sections);

    view('pages/buy-rent', [
        'title' => $page['seo_title'] ?? ucfirst($purpose === 'sale' ? 'Buy' : 'Rent') . ' Property in Pakistan',
        'description' => $page['seo_description'] ?? '',
        'heroPage' => true,
        'sections' => $sections,
        'purpose' => $purpose,
    ]);
}

function site_buy(): void
{
    site_buy_rent_page('buy', 'sale');
}

function site_rent(): void
{
    site_buy_rent_page('rent', 'rent');
}
