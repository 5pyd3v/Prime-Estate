<?php
declare(strict_types=1);

require_once BASE_PATH . '/admin/auth.php';
require_once BASE_PATH . '/admin/dashboard.php';
require_once BASE_PATH . '/admin/media.php';
require_once BASE_PATH . '/admin/settings.php';
require_once BASE_PATH . '/admin/property-types.php';
require_once BASE_PATH . '/admin/features.php';
require_once BASE_PATH . '/admin/cities.php';
require_once BASE_PATH . '/admin/properties.php';
require_once BASE_PATH . '/admin/projects.php';
require_once BASE_PATH . '/admin/agents.php';
require_once BASE_PATH . '/admin/services.php';
require_once BASE_PATH . '/admin/testimonials.php';
require_once BASE_PATH . '/admin/menus.php';
require_once BASE_PATH . '/admin/blog.php';
require_once BASE_PATH . '/admin/pages.php';
require_once BASE_PATH . '/admin/inquiries.php';
require_once BASE_PATH . '/admin/messages.php';

function register_admin_routes(Router $router): void
{
    $router->get('/', fn () => redirect('/admin/dashboard'));

    $router->get('/login', 'admin_login_show');
    $router->post('/login', 'admin_login_submit');
    $router->get('/logout', 'admin_logout');

    $router->get('/change-password', 'admin_change_password_show');
    $router->post('/change-password', 'admin_change_password_submit');

    $router->get('/dashboard', 'admin_dashboard');

    $router->get('/media', 'admin_media_index');
    $router->get('/media/picker', 'admin_media_picker_list');
    $router->post('/media/upload', 'admin_media_upload');
    $router->post('/media/:id/delete', fn ($p) => admin_media_delete((int) $p['id']));
    $router->post('/media/:id/alt', fn ($p) => admin_media_update_alt((int) $p['id']));

    $router->get('/settings', 'admin_settings_show');
    $router->post('/settings/update', 'admin_settings_update');

    $router->get('/property-types', 'admin_property_types_index');
    $router->post('/property-types/store', 'admin_property_types_store');
    $router->post('/property-types/:id/update', fn ($p) => admin_property_types_update((int) $p['id']));
    $router->post('/property-types/:id/delete', fn ($p) => admin_property_types_delete((int) $p['id']));

    $router->get('/features', 'admin_features_index');
    $router->post('/features/store', 'admin_features_store');
    $router->post('/features/:id/update', fn ($p) => admin_features_update((int) $p['id']));
    $router->post('/features/:id/delete', fn ($p) => admin_features_delete((int) $p['id']));

    $router->get('/cities', 'admin_cities_index');
    $router->post('/cities/store', 'admin_cities_store');
    $router->post('/cities/:id/update', fn ($p) => admin_cities_update((int) $p['id']));
    $router->post('/cities/:id/delete', fn ($p) => admin_cities_delete((int) $p['id']));
    $router->get('/cities/:id/areas', fn ($p) => admin_city_areas((int) $p['id']));
    $router->post('/cities/:id/areas/store', fn ($p) => admin_areas_store((int) $p['id']));
    $router->post('/cities/:id/areas/:areaId/update', fn ($p) => admin_areas_update((int) $p['id'], (int) $p['areaId']));
    $router->post('/cities/:id/areas/:areaId/delete', fn ($p) => admin_areas_delete((int) $p['id'], (int) $p['areaId']));

    $router->get('/properties', 'admin_properties_index');
    $router->get('/properties/create', 'admin_properties_create_show');
    $router->post('/properties/store', 'admin_properties_store');
    $router->get('/properties/:id/edit', fn ($p) => admin_properties_edit_show((int) $p['id']));
    $router->post('/properties/:id/update', fn ($p) => admin_properties_update((int) $p['id']));
    $router->post('/properties/:id/delete', fn ($p) => admin_properties_delete((int) $p['id']));
    $router->post('/properties/:id/duplicate', fn ($p) => admin_properties_duplicate((int) $p['id']));
    $router->post('/properties/:id/toggle-featured', fn ($p) => admin_properties_toggle((int) $p['id'], 'is_featured'));
    $router->post('/properties/:id/toggle-published', fn ($p) => admin_properties_toggle((int) $p['id'], 'is_published'));
    $router->post('/properties/:id/status', fn ($p) => admin_properties_set_status((int) $p['id']));
    $router->post('/properties/:id/images/:imageId/delete', fn ($p) => admin_property_image_delete((int) $p['id'], (int) $p['imageId']));
    $router->post('/properties/:id/images/:imageId/primary', fn ($p) => admin_property_image_primary((int) $p['id'], (int) $p['imageId']));
    $router->post('/properties/:id/images/reorder', fn ($p) => admin_property_image_reorder((int) $p['id']));

    $router->get('/projects', 'admin_projects_index');
    $router->get('/projects/create', 'admin_projects_create_show');
    $router->post('/projects/store', 'admin_projects_store');
    $router->get('/projects/:id/edit', fn ($p) => admin_projects_edit_show((int) $p['id']));
    $router->post('/projects/:id/update', fn ($p) => admin_projects_update((int) $p['id']));
    $router->post('/projects/:id/delete', fn ($p) => admin_projects_delete((int) $p['id']));
    $router->post('/projects/:id/toggle-featured', fn ($p) => admin_projects_toggle((int) $p['id'], 'is_featured'));
    $router->post('/projects/:id/toggle-published', fn ($p) => admin_projects_toggle((int) $p['id'], 'is_published'));
    $router->post('/projects/:id/images/:imageId/delete', fn ($p) => admin_project_image_delete((int) $p['id'], (int) $p['imageId']));
    $router->post('/projects/:id/images/:imageId/primary', fn ($p) => admin_project_image_primary((int) $p['id'], (int) $p['imageId']));
    $router->post('/projects/:id/images/reorder', fn ($p) => admin_project_image_reorder((int) $p['id']));

    $router->get('/agents', 'admin_agents_index');
    $router->get('/agents/create', 'admin_agents_create_show');
    $router->post('/agents/store', 'admin_agents_store');
    $router->get('/agents/:id/edit', fn ($p) => admin_agents_edit_show((int) $p['id']));
    $router->post('/agents/:id/update', fn ($p) => admin_agents_update((int) $p['id']));
    $router->post('/agents/:id/delete', fn ($p) => admin_agents_delete((int) $p['id']));

    $router->get('/services', 'admin_services_index');
    $router->post('/services/store', 'admin_services_store');
    $router->post('/services/:id/update', fn ($p) => admin_services_update((int) $p['id']));
    $router->post('/services/:id/delete', fn ($p) => admin_services_delete((int) $p['id']));

    $router->get('/testimonials', 'admin_testimonials_index');
    $router->post('/testimonials/store', 'admin_testimonials_store');
    $router->post('/testimonials/:id/update', fn ($p) => admin_testimonials_update((int) $p['id']));
    $router->post('/testimonials/:id/delete', fn ($p) => admin_testimonials_delete((int) $p['id']));

    $router->get('/menus', 'admin_menus_index');
    $router->post('/menus/store', 'admin_menus_store');
    $router->post('/menus/:id/update', fn ($p) => admin_menus_update((int) $p['id']));
    $router->post('/menus/:id/delete', fn ($p) => admin_menus_delete((int) $p['id']));

    $router->get('/blog', 'admin_blog_index');
    $router->get('/blog/create', 'admin_blog_create_show');
    $router->post('/blog/store', 'admin_blog_store');
    $router->get('/blog/:id/edit', fn ($p) => admin_blog_edit_show((int) $p['id']));
    $router->post('/blog/:id/update', fn ($p) => admin_blog_update((int) $p['id']));
    $router->post('/blog/:id/delete', fn ($p) => admin_blog_delete((int) $p['id']));
    $router->post('/blog/categories/store', 'admin_blog_categories_store');
    $router->post('/blog/categories/:id/delete', fn ($p) => admin_blog_categories_delete((int) $p['id']));

    $router->get('/pages', 'admin_pages_index');
    $router->get('/pages/:id/edit', fn ($p) => admin_pages_edit_show((int) $p['id']));
    $router->post('/pages/:id/update', fn ($p) => admin_pages_update((int) $p['id']));
    $router->post('/pages/:id/sections/store', fn ($p) => admin_page_sections_store((int) $p['id']));
    $router->post('/pages/:id/sections/:sectionId/update', fn ($p) => admin_page_sections_update((int) $p['id'], (int) $p['sectionId']));
    $router->post('/pages/:id/sections/:sectionId/delete', fn ($p) => admin_page_sections_delete((int) $p['id'], (int) $p['sectionId']));
    $router->post('/pages/:id/sections/reorder', fn ($p) => admin_page_sections_reorder((int) $p['id']));

    $router->get('/inquiries', 'admin_inquiries_index');
    $router->post('/inquiries/:id/status', fn ($p) => admin_inquiries_set_status((int) $p['id']));
    $router->post('/inquiries/:id/delete', fn ($p) => admin_inquiries_delete((int) $p['id']));

    $router->get('/messages', 'admin_messages_index');
    $router->post('/messages/:id/read', fn ($p) => admin_messages_mark_read((int) $p['id'], true));
    $router->post('/messages/:id/unread', fn ($p) => admin_messages_mark_read((int) $p['id'], false));
    $router->post('/messages/:id/contacted', fn ($p) => admin_messages_mark_contacted((int) $p['id']));
    $router->post('/messages/:id/delete', fn ($p) => admin_messages_delete((int) $p['id']));
}
