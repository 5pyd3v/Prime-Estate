<?php
declare(strict_types=1);

require_once BASE_PATH . '/site/home.php';
require_once BASE_PATH . '/site/properties.php';
require_once BASE_PATH . '/site/property-detail.php';
require_once BASE_PATH . '/site/buy-rent.php';
require_once BASE_PATH . '/site/inquiries.php';
require_once BASE_PATH . '/site/projects.php';
require_once BASE_PATH . '/site/agents.php';
require_once BASE_PATH . '/site/blog.php';
require_once BASE_PATH . '/site/about.php';
require_once BASE_PATH . '/site/services.php';
require_once BASE_PATH . '/site/contact.php';
require_once BASE_PATH . '/site/seo.php';

function register_public_routes(Router $router): void
{
    $router->get('/', 'site_home');

    $router->get('/properties', 'site_properties_index');
    $router->get('/property/:slug', 'site_property_detail');

    $router->get('/buy', 'site_buy');
    $router->get('/rent', 'site_rent');

    $router->get('/projects', 'site_projects_index');
    $router->get('/project/:slug', 'site_project_detail');

    $router->get('/agents', 'site_agents_index');
    $router->get('/agent/:slug', 'site_agent_detail');

    $router->get('/blog', 'site_blog_index');
    $router->get('/blog/:slug', 'site_blog_post');

    $router->get('/about-us', 'site_about');
    $router->get('/services', 'site_services_index');

    $router->post('/inquiries', 'site_submit_inquiry');

    $router->get('/contact', 'site_contact');
    $router->post('/contact', 'site_submit_contact_message');

    $router->get('/sitemap.xml', 'site_sitemap');
    $router->get('/robots.txt', 'site_robots');
}
