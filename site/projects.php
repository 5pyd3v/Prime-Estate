<?php
declare(strict_types=1);

function site_projects_index(): void
{
    $page = max(1, (int) input('page', 1));
    $filters = ['city_id' => (string) input('city', ''), 'status' => (string) input('status', '')];
    if ($filters['city_id']) {
        $city = City::bySlug($filters['city_id']);
        $filters['city_id'] = $city['id'] ?? 0;
    }
    $result = Project::paginated($page, 9, $filters);

    view('pages/projects', [
        'title' => 'Real Estate Projects in Pakistan',
        'description' => 'Explore new housing societies, apartment towers and commercial developments across Pakistan.',
        'heroPage' => false,
        'items' => $result['items'],
        'pagination' => $result['pagination'],
        'cities' => City::active(),
    ]);
}

function site_project_detail(array $params): void
{
    $project = Project::bySlug($params['slug']);
    if (!$project || !$project['is_published']) {
        abort(404);
    }

    $images = Project::images((int) $project['id']);
    $related = Project::related((int) $project['id'], $project['city_id'] ?: null, 3);
    $amenities = [];
    if (!empty($project['amenities'])) {
        $decoded = json_decode($project['amenities'], true);
        $amenities = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $project['amenities'])));
    }

    view('pages/project-detail', [
        'title' => $project['seo_title'] ?: $project['name'],
        'description' => $project['seo_description'] ?: '',
        'ogImage' => $images ? media_url($images[0]['path']) : null,
        'heroPage' => false,
        'project' => $project,
        'images' => $images,
        'amenities' => $amenities,
        'related' => $related,
    ]);
}
