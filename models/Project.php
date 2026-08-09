<?php
declare(strict_types=1);

class Project extends Model
{
    protected static string $table = 'projects';

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }

    public static function published(int $limit = 0, bool $featuredOnly = false): array
    {
        $sql = 'SELECT pr.*, c.name AS city_name FROM projects pr LEFT JOIN cities c ON c.id = pr.city_id WHERE pr.is_published = 1';
        if ($featuredOnly) {
            $sql .= ' AND pr.is_featured = 1';
        }
        $sql .= ' ORDER BY pr.is_featured DESC, pr.created_at DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        return self::db()->query($sql)->fetchAll();
    }

    public static function paginated(int $page, int $perPage = 9, array $filters = []): array
    {
        $where = ['pr.is_published = 1'];
        $params = [];

        if (!empty($filters['city_id'])) {
            $where[] = 'pr.city_id = ?';
            $params[] = $filters['city_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'pr.status = ?';
            $params[] = $filters['status'];
        }

        $whereSql = implode(' AND ', $where);
        $total = self::countWith($whereSql, $params);

        $pg = paginate($total, $page, $perPage);

        $sql = "SELECT pr.*, c.name AS city_name FROM projects pr LEFT JOIN cities c ON c.id = pr.city_id
                WHERE {$whereSql} ORDER BY pr.is_featured DESC, pr.created_at DESC LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'pagination' => $pg];
    }

    private static function countWith(string $whereSql, array $params): int
    {
        $stmt = self::db()->prepare('SELECT COUNT(*) FROM projects pr WHERE ' . $whereSql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public static function images(int $projectId): array
    {
        $stmt = self::db()->prepare(
            'SELECT pi.*, m.path, m.alt_text FROM project_images pi JOIN media m ON m.id = pi.media_id
             WHERE pi.project_id = ? ORDER BY pi.is_primary DESC, pi.sort_order'
        );
        $stmt->execute([$projectId]);
        return $stmt->fetchAll();
    }

    public static function related(int $excludeId, ?int $cityId, int $limit = 3): array
    {
        $sql = 'SELECT pr.*, c.name AS city_name FROM projects pr LEFT JOIN cities c ON c.id = pr.city_id
                WHERE pr.is_published = 1 AND pr.id != ?';
        $params = [$excludeId];
        if ($cityId) {
            $sql .= ' AND pr.city_id = ?';
            $params[] = $cityId;
        }
        $sql .= ' ORDER BY pr.is_featured DESC, pr.created_at DESC LIMIT ' . $limit;
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
