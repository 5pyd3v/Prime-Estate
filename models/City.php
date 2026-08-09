<?php
declare(strict_types=1);

class City extends Model
{
    protected static string $table = 'cities';

    public static function active(): array
    {
        return self::db()->query('SELECT * FROM cities WHERE is_active = 1 ORDER BY sort_order, name')->fetchAll();
    }

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }
}
