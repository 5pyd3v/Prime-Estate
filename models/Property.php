<?php
declare(strict_types=1);

class Property extends Model
{
    protected static string $table = 'properties';

    private static function baseSelect(): string
    {
        return 'SELECT p.*, c.name AS city_name, c.slug AS city_slug, a.name AS area_name,
                        pt.name AS type_name, pt.slug AS type_slug,
                        ag.name AS agent_name, ag.slug AS agent_slug,
                        (SELECT m.path FROM property_images pi JOIN media m ON m.id = pi.media_id
                         WHERE pi.property_id = p.id ORDER BY pi.is_primary DESC, pi.sort_order LIMIT 1) AS primary_image
                 FROM properties p
                 LEFT JOIN cities c ON c.id = p.city_id
                 LEFT JOIN areas a ON a.id = p.area_id
                 LEFT JOIN property_types pt ON pt.id = p.property_type_id
                 LEFT JOIN agents ag ON ag.id = p.agent_id';
    }

    public static function bySlug(string $slug): ?array
    {
        $stmt = self::db()->prepare(self::baseSelect() . ' WHERE p.slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * @param array $filters purpose, city, type, min_price, max_price, bedrooms, bathrooms, furnished, status, featured, q, sort
     */
    public static function search(array $filters, int $page = 1, int $perPage = 12): array
    {
        [$where, $params] = self::buildWhere($filters);
        $whereSql = implode(' AND ', $where);

        $total = self::countWith($whereSql, $params);
        $pg = paginate($total, $page, $perPage);

        $orderBy = match ($filters['sort'] ?? 'newest') {
            'price_asc' => 'p.price ASC',
            'price_desc' => 'p.price DESC',
            'oldest' => 'p.created_at ASC',
            default => 'p.is_featured DESC, p.created_at DESC',
        };

        $sql = self::baseSelect() . " WHERE {$whereSql} ORDER BY {$orderBy} LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'pagination' => $pg];
    }

    private static function buildWhere(array $filters): array
    {
        $where = ['p.is_published = 1'];
        $params = [];

        if (!empty($filters['purpose'])) {
            $where[] = 'p.purpose = ?';
            $params[] = $filters['purpose'];
        }
        if (!empty($filters['city'])) {
            $where[] = 'c.slug = ?';
            $params[] = $filters['city'];
        }
        if (!empty($filters['area'])) {
            $where[] = 'a.slug = ?';
            $params[] = $filters['area'];
        }
        if (!empty($filters['type'])) {
            $where[] = 'pt.slug = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['min_price'])) {
            $where[] = 'p.price >= ?';
            $params[] = (float) $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $where[] = 'p.price <= ?';
            $params[] = (float) $filters['max_price'];
        }
        if (!empty($filters['bedrooms'])) {
            $where[] = 'p.bedrooms >= ?';
            $params[] = (int) $filters['bedrooms'];
        }
        if (!empty($filters['bathrooms'])) {
            $where[] = 'p.bathrooms >= ?';
            $params[] = (int) $filters['bathrooms'];
        }
        if (!empty($filters['furnished'])) {
            $where[] = 'p.furnished_status = ?';
            $params[] = $filters['furnished'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'p.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['featured'])) {
            $where[] = 'p.is_featured = 1';
        }
        if (!empty($filters['q'])) {
            $where[] = '(p.title LIKE ? OR p.short_description LIKE ? OR p.address LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        return [$where, $params];
    }

    private static function countWith(string $whereSql, array $params): int
    {
        $stmt = self::db()->prepare(
            'SELECT COUNT(*) FROM properties p
             LEFT JOIN cities c ON c.id = p.city_id
             LEFT JOIN areas a ON a.id = p.area_id
             LEFT JOIN property_types pt ON pt.id = p.property_type_id
             WHERE ' . $whereSql
        );
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public static function featured(int $limit = 6, ?string $purpose = null): array
    {
        $sql = self::baseSelect() . ' WHERE p.is_published = 1 AND p.is_featured = 1';
        $params = [];
        if ($purpose) {
            $sql .= ' AND p.purpose = ?';
            $params[] = $purpose;
        }
        $sql .= ' ORDER BY p.created_at DESC LIMIT ' . (int) $limit;
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function similar(array $property, int $limit = 4): array
    {
        $stmt = self::db()->prepare(
            self::baseSelect() . ' WHERE p.is_published = 1 AND p.id != ? AND (p.city_id = ? OR p.property_type_id = ?)
             ORDER BY (p.city_id = ?) DESC, p.created_at DESC LIMIT ' . (int) $limit
        );
        $stmt->execute([$property['id'], $property['city_id'], $property['property_type_id'], $property['city_id']]);
        return $stmt->fetchAll();
    }

    public static function byAgent(int $agentId, int $limit = 0): array
    {
        $sql = self::baseSelect() . ' WHERE p.is_published = 1 AND p.agent_id = ? ORDER BY p.created_at DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$agentId]);
        return $stmt->fetchAll();
    }

    public static function images(int $propertyId): array
    {
        $stmt = self::db()->prepare(
            'SELECT pi.*, m.path, m.alt_text FROM property_images pi JOIN media m ON m.id = pi.media_id
             WHERE pi.property_id = ? ORDER BY pi.is_primary DESC, pi.sort_order'
        );
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public static function features(int $propertyId): array
    {
        $stmt = self::db()->prepare(
            'SELECT f.* FROM property_features pf JOIN features f ON f.id = pf.feature_id
             WHERE pf.property_id = ? ORDER BY f.sort_order'
        );
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll();
    }

    public static function setFeatures(int $propertyId, array $featureIds): void
    {
        $stmt = self::db()->prepare('DELETE FROM property_features WHERE property_id = ?');
        $stmt->execute([$propertyId]);
        if (empty($featureIds)) {
            return;
        }
        $stmt = self::db()->prepare('INSERT INTO property_features (property_id, feature_id) VALUES (?, ?)');
        foreach ($featureIds as $fid) {
            $stmt->execute([$propertyId, (int) $fid]);
        }
    }

    public static function incrementViews(int $propertyId): void
    {
        $stmt = self::db()->prepare('UPDATE properties SET views_count = views_count + 1 WHERE id = ?');
        $stmt->execute([$propertyId]);
    }

    public static function stats(): array
    {
        $row = self::db()->query(
            "SELECT
                COUNT(*) AS total,
                SUM(is_published = 1) AS published,
                SUM(is_featured = 1) AS featured,
                SUM(status = 'sold') AS sold,
                SUM(status = 'rented') AS rented
             FROM properties"
        )->fetch();
        return $row ?: [];
    }

    public static function adminList(array $filters, int $page = 1, int $perPage = 20): array
    {
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['q'])) {
            $where[] = 'p.title LIKE ?';
            $params[] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['status'])) {
            $where[] = 'p.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['purpose'])) {
            $where[] = 'p.purpose = ?';
            $params[] = $filters['purpose'];
        }
        if (isset($filters['published']) && $filters['published'] !== '') {
            $where[] = 'p.is_published = ?';
            $params[] = (int) $filters['published'];
        }

        $whereSql = implode(' AND ', $where);
        $total = self::countWith($whereSql, $params);
        $pg = paginate($total, $page, $perPage);

        $sql = self::baseSelect() . " WHERE {$whereSql} ORDER BY p.created_at DESC LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'pagination' => $pg];
    }
}
