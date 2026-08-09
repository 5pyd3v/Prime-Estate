<?php
declare(strict_types=1);

function admin_dashboard(): void
{
    Auth::require();

    $propertyStats = Property::stats();
    $stats = [
        'properties_total' => (int) ($propertyStats['total'] ?? 0),
        'properties_published' => (int) ($propertyStats['published'] ?? 0),
        'properties_featured' => (int) ($propertyStats['featured'] ?? 0),
        'properties_sold' => (int) ($propertyStats['sold'] ?? 0),
        'properties_rented' => (int) ($propertyStats['rented'] ?? 0),
        'inquiries_total' => (int) DB::connection()->query('SELECT COUNT(*) FROM inquiries')->fetchColumn(),
        'inquiries_new' => Inquiry::countNew(),
        'agents_total' => (int) DB::connection()->query('SELECT COUNT(*) FROM agents')->fetchColumn(),
        'projects_total' => (int) DB::connection()->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
        'blog_total' => (int) DB::connection()->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn(),
        'messages_unread' => ContactMessage::countUnread(),
    ];

    $recentInquiries = DB::connection()->query(
        "SELECT i.*, p.title AS property_title FROM inquiries i LEFT JOIN properties p ON p.id = i.property_id
         ORDER BY i.created_at DESC LIMIT 6"
    )->fetchAll();

    $recentProperties = DB::connection()->query(
        'SELECT p.*, c.name AS city_name FROM properties p LEFT JOIN cities c ON c.id = p.city_id
         ORDER BY p.created_at DESC LIMIT 6'
    )->fetchAll();

    $monthly = DB::connection()->query(
        "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS total
         FROM properties WHERE created_at >= (CURDATE() - INTERVAL 6 MONTH)
         GROUP BY ym ORDER BY ym"
    )->fetchAll();

    view('admin/dashboard', [
        'title' => 'Dashboard',
        'stats' => $stats,
        'recentInquiries' => $recentInquiries,
        'recentProperties' => $recentProperties,
        'monthly' => $monthly,
    ]);
}
