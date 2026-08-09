<?php
declare(strict_types=1);

class Agent extends Model
{
    protected static string $table = 'agents';

    public static function active(): array
    {
        return self::db()->query('SELECT * FROM agents WHERE is_active = 1 ORDER BY sort_order, name')->fetchAll();
    }

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }

    public static function propertyCount(int $agentId): int
    {
        $stmt = self::db()->prepare('SELECT COUNT(*) FROM properties WHERE agent_id = ? AND is_published = 1');
        $stmt->execute([$agentId]);
        return (int) $stmt->fetchColumn();
    }
}
