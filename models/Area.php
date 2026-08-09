<?php
declare(strict_types=1);

class Area extends Model
{
    protected static string $table = 'areas';

    public static function byCity(int $cityId): array
    {
        $stmt = self::db()->prepare('SELECT * FROM areas WHERE city_id = ? AND is_active = 1 ORDER BY sort_order, name');
        $stmt->execute([$cityId]);
        return $stmt->fetchAll();
    }

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }
}
