<?php
declare(strict_types=1);

function site_property_detail(array $params): void
{
    $property = Property::bySlug($params['slug']);
    if (!$property || !$property['is_published']) {
        abort(404);
    }

    Property::incrementViews((int) $property['id']);

    $images = Property::images((int) $property['id']);
    $features = Property::features((int) $property['id']);
    $similar = Property::similar($property, 4);
    $agent = $property['agent_id'] ? Agent::find((int) $property['agent_id']) : null;

    view('pages/property-detail', [
        'title' => $property['seo_title'] ?: $property['title'],
        'description' => $property['seo_description'] ?: $property['short_description'] ?: '',
        'ogImage' => $images ? media_url($images[0]['path']) : null,
        'heroPage' => false,
        'property' => $property,
        'images' => $images,
        'features' => $features,
        'similar' => $similar,
        'agent' => $agent,
    ]);
}
