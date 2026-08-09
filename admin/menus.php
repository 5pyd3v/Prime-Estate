<?php
declare(strict_types=1);

function admin_menus_index(): void
{
    Auth::require();
    $header = DB::connection()->query("SELECT * FROM menus WHERE location='header' ORDER BY sort_order")->fetchAll();
    $footer = DB::connection()->query("SELECT * FROM menus WHERE location='footer' ORDER BY sort_order")->fetchAll();
    view('admin/menus/index', ['title' => 'Menus', 'active' => 'menus', 'header' => $header, 'footer' => $footer]);
}

function menu_payload(): array
{
    return [
        'location' => in_array(input('location'), ['header', 'footer'], true) ? input('location') : 'header',
        'label' => trim((string) input('label', '')),
        'url' => trim((string) input('url', '')) ?: '/',
        'target' => input('target') === '_blank' ? '_blank' : '_self',
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ];
}

function admin_menus_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = menu_payload();
    if ($data['label'] === '') {
        flash('error', 'Label is required.');
        redirect('/admin/menus');
    }
    Menu::insert($data);
    flash('success', 'Menu item added.');
    redirect('/admin/menus');
}

function admin_menus_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Menu::update($id, menu_payload());
    flash('success', 'Menu item updated.');
    redirect('/admin/menus');
}

function admin_menus_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Menu::delete($id);
    flash('success', 'Menu item deleted.');
    redirect('/admin/menus');
}
