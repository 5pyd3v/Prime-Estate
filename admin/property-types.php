<?php
declare(strict_types=1);

function admin_property_types_index(): void
{
    Auth::require();
    $items = DB::connection()->query('SELECT * FROM property_types ORDER BY sort_order, name')->fetchAll();
    view('admin/property-types/index', ['title' => 'Property Types', 'active' => 'property-types', 'items' => $items]);
}

function admin_property_types_store(): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'Name is required.');
        redirect('/admin/property-types');
    }

    PropertyType::insert([
        'name' => $name,
        'slug' => unique_slug(fn ($slug) => (bool) PropertyType::findBy('slug', $slug), $name),
        'icon' => trim((string) input('icon', '')) ?: null,
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'Property type added.');
    redirect('/admin/property-types');
}

function admin_property_types_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'Name is required.');
        redirect('/admin/property-types');
    }

    $slug = slug_for_update('property_types', $id, $name, PropertyType::find($id));

    PropertyType::update($id, [
        'name' => $name,
        'slug' => $slug,
        'icon' => trim((string) input('icon', '')) ?: null,
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'Property type updated.');
    redirect('/admin/property-types');
}

function admin_property_types_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    PropertyType::delete($id);
    flash('success', 'Property type deleted.');
    redirect('/admin/property-types');
}
