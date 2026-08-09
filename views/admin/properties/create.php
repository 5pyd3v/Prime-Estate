<?php
/** @var array $types */
/** @var array $cities */
/** @var array $features */
ob_start();
view('admin/properties/_form', [
    'property' => null,
    'types' => $types,
    'cities' => $cities,
    'features' => $features,
    'selectedFeatures' => [],
    'images' => [],
]);
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Add Property', 'active' => 'properties', 'content' => $content]);
