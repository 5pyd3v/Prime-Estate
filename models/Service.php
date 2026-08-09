<?php
declare(strict_types=1);

class Service extends Model
{
    protected static string $table = 'services';

    public static function published(): array
    {
        return self::db()->query('SELECT * FROM services WHERE is_published = 1 ORDER BY sort_order')->fetchAll();
    }

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }
}
