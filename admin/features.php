<?php
declare(strict_types=1);

function admin_features_index(): void
{
    Auth::require();
    $items = DB::connection()->query('SELECT * FROM features ORDER BY sort_order, name')->fetchAll();
    view('admin/features/index', ['title' => 'Features', 'active' => 'features', 'items' => $items]);
}

function admin_features_store(): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'Name is required.');
        redirect('/admin/features');
    }

    Feature::insert([
        'name' => $name,
        'slug' => unique_slug(fn ($slug) => (bool) Feature::findBy('slug', $slug), $name),
        'icon' => trim((string) input('icon', '')) ?: null,
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'Feature added.');
    redirect('/admin/features');
}

function admin_features_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'Name is required.');
        redirect('/admin/features');
    }

    Feature::update($id, [
        'name' => $name,
        'slug' => slug_for_update('features', $id, $name, Feature::find($id)),
        'icon' => trim((string) input('icon', '')) ?: null,
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'Feature updated.');
    redirect('/admin/features');
}

function admin_features_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Feature::delete($id);
    flash('success', 'Feature deleted.');
    redirect('/admin/features');
}
