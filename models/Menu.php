<?php
declare(strict_types=1);

class Menu extends Model
{
    protected static string $table = 'menus';

    public static function forLocation(string $location): array
    {
        $stmt = self::db()->prepare('SELECT * FROM menus WHERE location = ? AND is_active = 1 AND parent_id IS NULL ORDER BY sort_order');
        $stmt->execute([$location]);
        return $stmt->fetchAll();
    }
}
