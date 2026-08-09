<?php
declare(strict_types=1);

function admin_services_index(): void
{
    Auth::require();
    $items = DB::connection()->query('SELECT * FROM services ORDER BY sort_order')->fetchAll();
    view('admin/services/index', ['title' => 'Services', 'active' => 'services', 'items' => $items]);
}

function service_payload(): array
{
    return [
        'title' => trim((string) input('title', '')),
        'icon' => trim((string) input('icon', '')) ?: null,
        'short_description' => trim((string) input('short_description', '')) ?: null,
        'description' => trim((string) input('description', '')) ?: null,
        'sort_order' => (int) input('sort_order', 0),
        'is_published' => input('is_published') ? 1 : 0,
    ];
}

function admin_services_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = service_payload();
    if ($data['title'] === '') {
        flash('error', 'Title is required.');
        redirect('/admin/services');
    }
    $data['slug'] = unique_slug(fn ($slug) => (bool) Service::findBy('slug', $slug), $data['title']);
    Service::insert($data);
    flash('success', 'Service added.');
    redirect('/admin/services');
}

function admin_services_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = service_payload();
    if ($data['title'] === '') {
        flash('error', 'Title is required.');
        redirect('/admin/services');
    }
    $existing = Service::find($id);
    $data['slug'] = $existing && $existing['title'] === $data['title'] ? $existing['slug'] : unique_slug(function ($slug) use ($id) {
        $stmt = DB::connection()->prepare('SELECT id FROM services WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $id]);
        return (bool) $stmt->fetchColumn();
    }, $data['title']);
    Service::update($id, $data);
    flash('success', 'Service updated.');
    redirect('/admin/services');
}

function admin_services_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Service::delete($id);
    flash('success', 'Service deleted.');
    redirect('/admin/services');
}
