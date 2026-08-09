<?php
declare(strict_types=1);

const AVAILABLE_SECTION_TYPES = [
    'hero' => 'Hero', 'text' => 'Text', 'featured-properties' => 'Featured Properties',
    'property-types' => 'Property Types Grid', 'why-us' => 'Why Choose Us', 'services' => 'Services',
    'testimonials' => 'Testimonials', 'team' => 'Team', 'statistics' => 'Statistics',
    'cta' => 'Call to Action', 'faq' => 'FAQ', 'map' => 'Map',
];

function admin_pages_index(): void
{
    Auth::require();
    $items = Page::all('title');
    view('admin/pages/index', ['title' => 'Pages', 'active' => 'pages', 'items' => $items]);
}

function admin_pages_edit_show(int $id): void
{
    Auth::require();
    $page = Page::find($id);
    if (!$page) {
        abort(404);
    }
    $sections = PageSection::forPage($id, false);
    view('admin/pages/edit', ['title' => 'Edit Page — ' . $page['title'], 'active' => 'pages', 'page' => $page, 'sections' => $sections]);
}

function admin_pages_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Page::update($id, [
        'title' => trim((string) input('title', '')),
        'seo_title' => trim((string) input('seo_title', '')) ?: null,
        'seo_description' => trim((string) input('seo_description', '')) ?: null,
        'status' => input('status') === 'draft' ? 'draft' : 'published',
    ]);
    flash('success', 'Page updated.');
    redirect("/admin/pages/{$id}/edit");
}

function admin_page_sections_store(int $pageId): void
{
    Auth::require();
    Csrf::verifyRequest();
    $type = input('section_type', 'text');
    if (!array_key_exists($type, AVAILABLE_SECTION_TYPES)) {
        $type = 'text';
    }
    $stmt = DB::connection()->prepare('SELECT COALESCE(MAX(sort_order),0)+1 FROM page_sections WHERE page_id=?');
    $stmt->execute([$pageId]);
    PageSection::insert([
        'page_id' => $pageId,
        'section_type' => $type,
        'heading' => 'New ' . AVAILABLE_SECTION_TYPES[$type] . ' Section',
        'subheading' => null,
        'content' => null,
        'sort_order' => (int) $stmt->fetchColumn(),
        'is_active' => 1,
    ]);
    flash('success', 'Section added.');
    redirect("/admin/pages/{$pageId}/edit");
}

function admin_page_sections_update(int $pageId, int $sectionId): void
{
    Auth::require();
    Csrf::verifyRequest();
    PageSection::update($sectionId, [
        'heading' => trim((string) input('heading', '')) ?: null,
        'subheading' => trim((string) input('subheading', '')) ?: null,
        'content' => trim((string) input('content', '')) ?: null,
        'image_id' => (int) input('image_id') ?: null,
        'is_active' => input('is_active') ? 1 : 0,
    ]);
    flash('success', 'Section updated.');
    redirect("/admin/pages/{$pageId}/edit");
}

function admin_page_sections_delete(int $pageId, int $sectionId): void
{
    Auth::require();
    Csrf::verifyRequest();
    PageSection::delete($sectionId);
    flash('success', 'Section removed.');
    redirect("/admin/pages/{$pageId}/edit");
}

function admin_page_sections_reorder(int $pageId): void
{
    Auth::require();
    $body = json_decode((string) file_get_contents('php://input'), true) ?? [];
    if (!Csrf::verify($body['_csrf'] ?? null)) {
        json_response(['error' => 'Invalid session token.'], 419);
    }
    PageSection::reorder(array_map('intval', $body['order'] ?? []));
    json_response(['ok' => true]);
}
