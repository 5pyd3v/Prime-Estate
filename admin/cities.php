<?php
declare(strict_types=1);

function admin_cities_index(): void
{
    Auth::require();
    $items = DB::connection()->query(
        'SELECT c.*, COUNT(a.id) AS area_count FROM cities c LEFT JOIN areas a ON a.city_id = c.id GROUP BY c.id ORDER BY c.sort_order, c.name'
    )->fetchAll();
    view('admin/cities/index', ['title' => 'Cities & Areas', 'active' => 'cities', 'items' => $items]);
}

function admin_cities_store(): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'City name is required.');
        redirect('/admin/cities');
    }

    City::insert([
        'name' => $name,
        'slug' => unique_slug(fn ($slug) => (bool) City::findBy('slug', $slug), $name),
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'City added.');
    redirect('/admin/cities');
}

function admin_cities_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'City name is required.');
        redirect('/admin/cities');
    }

    City::update($id, [
        'name' => $name,
        'slug' => slug_for_update('cities', $id, $name, City::find($id)),
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'City updated.');
    redirect('/admin/cities');
}

function admin_cities_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    City::delete($id);
    flash('success', 'City deleted.');
    redirect('/admin/cities');
}

function admin_city_areas(int $cityId): void
{
    Auth::require();
    $city = City::find($cityId);
    if (!$city) {
        abort(404);
    }
    $areas = DB::connection()->prepare('SELECT * FROM areas WHERE city_id = ? ORDER BY sort_order, name');
    $areas->execute([$cityId]);

    view('admin/cities/areas', ['title' => 'Areas — ' . $city['name'], 'active' => 'cities', 'city' => $city, 'areas' => $areas->fetchAll()]);
}

function admin_areas_store(int $cityId): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    if ($name === '') {
        flash('error', 'Area name is required.');
        redirect("/admin/cities/{$cityId}/areas");
    }

    Area::insert([
        'city_id' => $cityId,
        'name' => $name,
        'slug' => unique_slug(function ($slug) use ($cityId) {
            $stmt = DB::connection()->prepare('SELECT id FROM areas WHERE city_id = ? AND slug = ?');
            $stmt->execute([$cityId, $slug]);
            return (bool) $stmt->fetchColumn();
        }, $name),
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'Area added.');
    redirect("/admin/cities/{$cityId}/areas");
}

function admin_areas_update(int $cityId, int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $name = trim((string) input('name', ''));
    Area::update($id, [
        'name' => $name,
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ]);

    flash('success', 'Area updated.');
    redirect("/admin/cities/{$cityId}/areas");
}

function admin_areas_delete(int $cityId, int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Area::delete($id);
    flash('success', 'Area deleted.');
    redirect("/admin/cities/{$cityId}/areas");
}
