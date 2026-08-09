<?php
declare(strict_types=1);

class PropertyType extends Model
{
    protected static string $table = 'property_types';

    public static function active(): array
    {
        return self::db()->query('SELECT * FROM property_types WHERE is_active = 1 ORDER BY sort_order, name')->fetchAll();
    }

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }

    public static function withCounts(): array
    {
        $sql = 'SELECT pt.*, COUNT(p.id) AS property_count
                FROM property_types pt
                LEFT JOIN properties p ON p.property_type_id = pt.id AND p.is_published = 1
                WHERE pt.is_active = 1
                GROUP BY pt.id
                ORDER BY pt.sort_order, pt.name';
        return self::db()->query($sql)->fetchAll();
    }
}
