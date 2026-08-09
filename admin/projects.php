<?php
declare(strict_types=1);

function admin_projects_index(): void
{
    Auth::require();
    $items = DB::connection()->query(
        'SELECT pr.*, c.name AS city_name FROM projects pr LEFT JOIN cities c ON c.id = pr.city_id ORDER BY pr.created_at DESC'
    )->fetchAll();
    view('admin/projects/index', ['title' => 'Projects', 'active' => 'projects', 'items' => $items]);
}

function project_payload(): array
{
    return [
        'name' => trim((string) input('name', '')),
        'developer' => trim((string) input('developer', '')) ?: null,
        'city_id' => (int) input('city_id') ?: null,
        'location' => trim((string) input('location', '')) ?: null,
        'description' => trim((string) input('description', '')) ?: null,
        'logo_media_id' => (int) input('logo_media_id') ?: null,
        'starting_price' => input('starting_price') !== '' ? (float) input('starting_price') : null,
        'price_label' => trim((string) input('price_label', '')) ?: null,
        'status' => in_array(input('status'), ['upcoming', 'ongoing', 'completed'], true) ? input('status') : 'upcoming',
        'completion_date' => trim((string) input('completion_date', '')) ?: null,
        'amenities' => trim((string) input('amenities', '')) ?: null,
        'payment_plan' => trim((string) input('payment_plan', '')) ?: null,
        'brochure_media_id' => (int) input('brochure_media_id') ?: null,
        'video_url' => trim((string) input('video_url', '')) ?: null,
        'map_url' => trim((string) input('map_url', '')) ?: null,
        'is_featured' => input('is_featured') ? 1 : 0,
        'is_published' => input('is_published') ? 1 : 0,
        'seo_title' => trim((string) input('seo_title', '')) ?: null,
        'seo_description' => trim((string) input('seo_description', '')) ?: null,
    ];
}

function admin_projects_create_show(): void
{
    Auth::require();
    view('admin/projects/create', ['title' => 'Add Project', 'active' => 'projects', 'project' => null, 'cities' => City::active(), 'images' => []]);
}

function admin_projects_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = project_payload();
    if ($data['name'] === '') {
        flash('error', 'Project name is required.');
        redirect('/admin/projects/create');
    }
    $data['slug'] = unique_slug(fn ($slug) => (bool) Project::findBy('slug', $slug), $data['name']);
    $id = Project::insert($data);
    handle_project_image_uploads($id);
    flash('success', 'Project created.');
    redirect("/admin/projects/{$id}/edit");
}

function admin_projects_edit_show(int $id): void
{
    Auth::require();
    $project = Project::find($id);
    if (!$project) {
        abort(404);
    }
    view('admin/projects/edit', [
        'title' => 'Edit Project', 'active' => 'projects', 'project' => $project,
        'cities' => City::active(), 'images' => Project::images($id),
    ]);
}

function admin_projects_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    $project = Project::find($id);
    if (!$project) {
        abort(404);
    }
    $data = project_payload();
    if ($data['name'] === '') {
        flash('error', 'Project name is required.');
        redirect("/admin/projects/{$id}/edit");
    }
    $data['slug'] = slug_for_update('projects', $id, $data['name'], $project);
    Project::update($id, $data);
    handle_project_image_uploads($id);
    flash('success', 'Project updated.');
    redirect("/admin/projects/{$id}/edit");
}

function handle_project_image_uploads(int $projectId): void
{
    if (empty($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        return;
    }
    $stmt = DB::connection()->prepare('SELECT COUNT(*) FROM project_images WHERE project_id = ?');
    $stmt->execute([$projectId]);
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
            $mediaId = Upload::handle($file, 'projects');
            $isPrimary = $existingCount === 0 && $i === 0;
            $stmt2 = DB::connection()->prepare('SELECT COALESCE(MAX(sort_order),0)+1 FROM project_images WHERE project_id=?');
            $stmt2->execute([$projectId]);
            $nextOrder = (int) $stmt2->fetchColumn();
            if ($isPrimary) {
                DB::connection()->prepare('UPDATE project_images SET is_primary=0 WHERE project_id=?')->execute([$projectId]);
            }
            DB::connection()->prepare('INSERT INTO project_images (project_id, media_id, sort_order, is_primary) VALUES (?,?,?,?)')
                ->execute([$projectId, $mediaId, $nextOrder, $isPrimary ? 1 : 0]);
            $existingCount++;
        } catch (Throwable $e) {
            error_log('Project image upload failed: ' . $e->getMessage());
        }
    }
}

function admin_projects_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    foreach (Project::images($id) as $img) {
        $path = BASE_PATH . '/public/uploads/' . $img['path'];
        if (is_file($path)) {
            @unlink($path);
        }
    }
    Project::delete($id);
    flash('success', 'Project deleted.');
    redirect('/admin/projects');
}

function admin_projects_toggle(int $id, string $field): void
{
    Auth::require();
    Csrf::verifyRequest();
    $project = Project::find($id);
    if ($project) {
        Project::update($id, [$field => $project[$field] ? 0 : 1]);
    }
    redirect($_SERVER['HTTP_REFERER'] ?? '/admin/projects');
}

function admin_project_image_delete(int $projectId, int $imageId): void
{
    Auth::require();
    Csrf::verifyRequest();
    DB::connection()->prepare('DELETE FROM project_images WHERE id=? AND project_id=?')->execute([$imageId, $projectId]);
    json_response(['ok' => true]);
}

function admin_project_image_primary(int $projectId, int $imageId): void
{
    Auth::require();
    Csrf::verifyRequest();
    DB::connection()->prepare('UPDATE project_images SET is_primary=0 WHERE project_id=?')->execute([$projectId]);
    DB::connection()->prepare('UPDATE project_images SET is_primary=1 WHERE id=? AND project_id=?')->execute([$imageId, $projectId]);
    json_response(['ok' => true]);
}

function admin_project_image_reorder(int $projectId): void
{
    Auth::require();
    $body = json_decode((string) file_get_contents('php://input'), true) ?? [];
    if (!Csrf::verify($body['_csrf'] ?? null)) {
        json_response(['error' => 'Invalid session token.'], 419);
    }
    $stmt = DB::connection()->prepare('UPDATE project_images SET sort_order=? WHERE id=?');
    foreach (array_map('intval', $body['order'] ?? []) as $index => $imgId) {
        $stmt->execute([$index, $imgId]);
    }
    json_response(['ok' => true]);
}
