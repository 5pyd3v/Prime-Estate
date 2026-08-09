<?php
/** @var array $property */
/** @var array $types */
/** @var array $cities */
/** @var array $features */
/** @var array $selectedFeatures */
/** @var array $images */
ob_start();
view('admin/properties/_form', [
    'property' => $property,
    'types' => $types,
    'cities' => $cities,
    'features' => $features,
    'selectedFeatures' => $selectedFeatures,
    'images' => $images,
]);
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Edit Property', 'active' => 'properties', 'content' => $content]);
