<?php
declare(strict_types=1);

function property_filters_from_request(): array
{
    return [
        'purpose' => (string) input('purpose', ''),
        'city' => (string) input('city', ''),
        'area' => (string) input('area', ''),
        'type' => (string) input('type', ''),
        'min_price' => (string) input('min_price', ''),
        'max_price' => (string) input('max_price', ''),
        'bedrooms' => (string) input('bedrooms', ''),
        'bathrooms' => (string) input('bathrooms', ''),
        'furnished' => (string) input('furnished', ''),
        'status' => (string) input('status', ''),
        'featured' => (string) input('featured', ''),
        'q' => (string) input('q', ''),
        'sort' => (string) input('sort', 'newest'),
    ];
}

function site_properties_index(): void
{
    $filters = property_filters_from_request();
    $page = max(1, (int) input('page', 1));
    $result = Property::search($filters, $page, 12);

    $isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== '';

    if ($isAjax) {
        view('pages/_properties-results', ['items' => $result['items'], 'pagination' => $result['pagination']]);
        return;
    }

    view('pages/properties', [
        'title' => 'Properties for Sale & Rent in Pakistan',
        'description' => 'Browse verified houses, apartments, plots and commercial properties for sale and rent across Pakistan.',
        'heroPage' => false,
        'items' => $result['items'],
        'pagination' => $result['pagination'],
        'filters' => $filters,
        'cities' => City::active(),
        'types' => PropertyType::active(),
    ]);
}
