<?php
declare(strict_types=1);

function site_services_index(): void
{
    view('pages/services', [
        'title' => 'Our Services',
        'description' => 'Property sales, rentals, management, investment consulting and valuation services from Prime Estates.',
        'heroPage' => false,
        'services' => Service::published(),
    ]);
}
