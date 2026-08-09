<?php
declare(strict_types=1);

function admin_properties_index(): void
{
    Auth::require();
    $page = max(1, (int) input('page', 1));
    $filters = [
        'q' => trim((string) input('q', '')),
        'status' => (string) input('status', ''),
        'purpose' => (string) input('purpose', ''),
        'published' => (string) input('published', ''),
    ];
    $result = Property::adminList($filters, $page, 15);

    view('admin/properties/index', [
        'title' => 'Properties',
        'active' => 'properties',
        'items' => $result['items'],
        'pagination' => $result['pagination'],
        'filters' => $filters,
    ]);
}

function property_form_meta(): array
{
    return [
        'types' => PropertyType::all('sort_order, name'),
        'cities' => City::active(),
        'features' => Feature::active(),
    ];
}

function admin_properties_create_show(): void
{
    Auth::require();
    view('admin/properties/create', array_merge(['title' => 'Add Property', 'active' => 'properties', 'property' => null, 'selectedFeatures' => [], 'images' => []], property_form_meta()));
}

function properties_payload_from_request(): array
{
    return [
        'title' => trim((string) input('title', '')),
        'property_type_id' => (int) input('property_type_id') ?: null,
        'purpose' => in_array(input('purpose'), ['sale', 'rent'], true) ? input('purpose') : 'sale',
        'price' => (float) input('price', 0),
        'price_label' => trim((string) input('price_label', '')) ?: null,
        'currency' => trim((string) input('currency', 'PKR')) ?: 'PKR',
        'status' => in_array(input('status'), ['available', 'sold', 'rented', 'under_offer'], true) ? input('status') : 'available',
        'is_featured' => input('is_featured') ? 1 : 0,
        'is_published' => input('is_published') ? 1 : 0,
        'city_id' => (int) input('city_id') ?: null,
        'area_id' => (int) input('area_id') ?: null,
        'address' => trim((string) input('address', '')) ?: null,
        'latitude' => input('latitude') !== '' && input('latitude') !== null ? (float) input('latitude') : null,
        'longitude' => input('longitude') !== '' && input('longitude') !== null ? (float) input('longitude') : null,
        'map_url' => trim((string) input('map_url', '')) ?: null,
        'bedrooms' => input('bedrooms') !== '' ? (int) input('bedrooms') : null,
        'bathrooms' => input('bathrooms') !== '' ? (int) input('bathrooms') : null,
        'kitchens' => input('kitchens') !== '' ? (int) input('kitchens') : null,
        'parking_spaces' => input('parking_spaces') !== '' ? (int) input('parking_spaces') : null,
        'floors' => input('floors') !== '' ? (int) input('floors') : null,
        'area_size' => input('area_size') !== '' ? (float) input('area_size') : null,
        'area_unit' => trim((string) input('area_unit', 'Marla')) ?: 'Marla',
        'covered_area' => input('covered_area') !== '' ? (float) input('covered_area') : null,
        'lot_area' => input('lot_area') !== '' ? (float) input('lot_area') : null,
        'year_built' => input('year_built') !== '' ? (int) input('year_built') : null,
        'furnished_status' => in_array(input('furnished_status'), ['unfurnished', 'semi_furnished', 'furnished'], true) ? input('furnished_status') : 'unfurnished',
        'short_description' => trim((string) input('short_description', '')) ?: null,
        'description' => trim((string) input('description', '')) ?: null,
        'video_url' => trim((string) input('video_url', '')) ?: null,
        'virtual_tour_url' => trim((string) input('virtual_tour_url', '')) ?: null,
        'agent_id' => (int) input('agent_id') ?: null,
        'seo_title' => trim((string) input('seo_title', '')) ?: null,
        'seo_description' => trim((string) input('seo_description', '')) ?: null,
        'seo_keywords' => trim((string) input('seo_keywords', '')) ?: null,
    ];
}

function admin_properties_store(): void
{
    Auth::require();
    Csrf::verifyRequest();

    $data = properties_payload_from_request();
    if ($data['title'] === '') {
        flash('error', 'Title is required.');
        redirect('/admin/properties/create');
    }

    $data['slug'] = unique_slug(fn ($slug) => (bool) Property::findBy('slug', $slug), $data['title']);
    $data['created_by'] = Auth::id();

    $id = Property::insert($data);

    $featureIds = array_map('intval', (array) input('features', []));
    Property::setFeatures($id, $featureIds);

    handle_property_image_uploads($id);

    flash('success', 'Property created successfully.');
    redirect("/admin/properties/{$id}/edit");
}

function admin_properties_edit_show(int $id): void
{
    Auth::require();
    $property = Property::find($id);
    if (!$property) {
        abort(404);
    }
    $selectedFeatures = array_column(Property::features($id), 'id');
    $images = Property::images($id);

    view('admin/properties/edit', array_merge(
        ['title' => 'Edit Property', 'active' => 'properties', 'property' => $property, 'selectedFeatures' => $selectedFeatures, 'images' => $images],
        property_form_meta()
    ));
}

function admin_properties_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $property = Property::find($id);
    if (!$property) {
        abort(404);
    }

    $data = properties_payload_from_request();
    if ($data['title'] === '') {
        flash('error', 'Title is required.');
        redirect("/admin/properties/{$id}/edit");
    }

    if ($data['title'] !== $property['title']) {
        $data['slug'] = unique_slug(function ($slug) use ($id) {
            $stmt = DB::connection()->prepare('SELECT id FROM properties WHERE slug = ? AND id != ?');
            $stmt->execute([$slug, $id]);
            return (bool) $stmt->fetchColumn();
        }, $data['title']);
    }

    Property::update($id, $data);

    $featureIds = array_map('intval', (array) input('features', []));
    Property::setFeatures($id, $featureIds);

    handle_property_image_uploads($id);

    flash('success', 'Property updated successfully.');
    redirect("/admin/properties/{$id}/edit");
}

function handle_property_image_uploads(int $propertyId): void
{
    if (empty($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        return;
    }

    $stmt = DB::connection()->prepare('SELECT COUNT(*) FROM property_images WHERE property_id = ?');
    $stmt->execute([$propertyId]);
    $existingCount = (int) $stmt->fetchColumn();

    $count = count($_FILES['images']['name']);
    for ($i = 0; $i < $count; $i++) {
        if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        $file = [
            'name' => $_FILES['images']['name'][$i],
            'type' => $_FILES['images']['type'][$i],
            'tmp_name' => $_FILES['images']['tmp_name'][$i],
            'error' => $_FILES['images']['error'][$i],
            'size' => $_FILES['images']['size'][$i],
        ];
        try {
            $mediaId = Upload::handle($file, 'properties');
            PropertyImage::add($propertyId, $mediaId, $existingCount === 0 && $i === 0);
            $existingCount++;
        } catch (Throwable $e) {
            error_log('Property image upload failed: ' . $e->getMessage());
        }
    }
}

function admin_properties_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    foreach (Property::images($id) as $img) {
        $path = BASE_PATH . '/public/uploads/' . $img['path'];
        if (is_file($path)) {
            @unlink($path);
        }
    }
    Property::delete($id);
    flash('success', 'Property deleted.');
    redirect('/admin/properties');
}

function admin_properties_duplicate(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $property = Property::find($id);
    if (!$property) {
        abort(404);
    }

    unset($property['id']);
    $property['title'] = $property['title'] . ' (Copy)';
    $property['slug'] = unique_slug(fn ($slug) => (bool) Property::findBy('slug', $slug), $property['title']);
    $property['is_published'] = 0;
    $property['is_featured'] = 0;
    $property['views_count'] = 0;
    $property['created_by'] = Auth::id();
    unset($property['created_at'], $property['updated_at'], $property['city_name'], $property['city_slug'], $property['area_name'], $property['type_name'], $property['type_slug'], $property['agent_name'], $property['agent_slug']);

    $newId = Property::insert($property);

    $featureIds = array_column(Property::features($id), 'id');
    Property::setFeatures($newId, $featureIds);

    foreach (Property::images($id) as $img) {
        PropertyImage::add($newId, (int) $img['media_id'], (bool) $img['is_primary']);
    }

    flash('success', 'Property duplicated. You are now editing the copy.');
    redirect("/admin/properties/{$newId}/edit");
}

function admin_properties_toggle(int $id, string $field): void
{
    Auth::require();
    Csrf::verifyRequest();
    $property = Property::find($id);
    if ($property) {
        Property::update($id, [$field => $property[$field] ? 0 : 1]);
    }
    flash('success', 'Property updated.');
    redirect($_SERVER['HTTP_REFERER'] ?? '/admin/properties');
}

function admin_properties_set_status(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    $status = input('status', 'available');
    if (in_array($status, ['available', 'sold', 'rented', 'under_offer'], true)) {
        Property::update($id, ['status' => $status]);
        flash('success', 'Status updated.');
    }
    redirect($_SERVER['HTTP_REFERER'] ?? '/admin/properties');
}

function admin_property_image_delete(int $propertyId, int $imageId): void
{
    Auth::require();
    Csrf::verifyRequest();

    $stmt = DB::connection()->prepare('SELECT * FROM property_images WHERE id = ? AND property_id = ?');
    $stmt->execute([$imageId, $propertyId]);
    $img = $stmt->fetch();
    if ($img) {
        PropertyImage::delete($imageId);
    }

    json_response(['ok' => true]);
}

function admin_property_image_primary(int $propertyId, int $imageId): void
{
    Auth::require();
    Csrf::verifyRequest();
    PropertyImage::setPrimary($imageId, $propertyId);
    json_response(['ok' => true]);
}

function admin_property_image_reorder(int $propertyId): void
{
    Auth::require();
    $body = json_decode((string) file_get_contents('php://input'), true) ?? [];
    if (!Csrf::verify($body['_csrf'] ?? null)) {
        json_response(['error' => 'Invalid session token.'], 419);
    }
    PropertyImage::reorder(array_map('intval', $body['order'] ?? []));
    json_response(['ok' => true]);
}
