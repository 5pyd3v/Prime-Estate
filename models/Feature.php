<?php
declare(strict_types=1);

class Feature extends Model
{
    protected static string $table = 'features';

    public static function active(): array
    {
        return self::db()->query('SELECT * FROM features WHERE is_active = 1 ORDER BY sort_order, name')->fetchAll();
    }
}
