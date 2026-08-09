<?php
declare(strict_types=1);

class BlogPost extends Model
{
    protected static string $table = 'blog_posts';

    private static function baseSelect(): string
    {
        return 'SELECT bp.*, bc.name AS category_name, bc.slug AS category_slug, u.name AS author_name
                 FROM blog_posts bp
                 LEFT JOIN blog_categories bc ON bc.id = bp.category_id
                 LEFT JOIN users u ON u.id = bp.author_id';
    }

    public static function bySlug(string $slug): ?array
    {
        $stmt = self::db()->prepare(self::baseSelect() . ' WHERE bp.slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function published(array $filters = [], int $page = 1, int $perPage = 9): array
    {
        $where = ["bp.status = 'published'", 'bp.published_at <= NOW()'];
        $params = [];

        if (!empty($filters['category'])) {
            $where[] = 'bc.slug = ?';
            $params[] = $filters['category'];
        }
        if (!empty($filters['tag'])) {
            $where[] = 'bp.id IN (SELECT blog_post_id FROM blog_post_tags bpt JOIN tags t ON t.id = bpt.tag_id WHERE t.slug = ?)';
            $params[] = $filters['tag'];
        }

        $whereSql = implode(' AND ', $where);
        $countStmt = self::db()->prepare('SELECT COUNT(*) FROM blog_posts bp LEFT JOIN blog_categories bc ON bc.id = bp.category_id WHERE ' . $whereSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $pg = paginate($total, $page, $perPage);
        $sql = self::baseSelect() . " WHERE {$whereSql} ORDER BY bp.published_at DESC LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'pagination' => $pg];
    }

    public static function related(int $excludeId, ?int $categoryId, int $limit = 3): array
    {
        $sql = self::baseSelect() . " WHERE bp.status = 'published' AND bp.id != ?";
        $params = [$excludeId];
        if ($categoryId) {
            $sql .= ' AND bp.category_id = ?';
            $params[] = $categoryId;
        }
        $sql .= ' ORDER BY bp.published_at DESC LIMIT ' . $limit;
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function tags(int $postId): array
    {
        $stmt = self::db()->prepare('SELECT t.* FROM blog_post_tags bpt JOIN tags t ON t.id = bpt.tag_id WHERE bpt.blog_post_id = ?');
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public static function setTags(int $postId, array $tagIds): void
    {
        $stmt = self::db()->prepare('DELETE FROM blog_post_tags WHERE blog_post_id = ?');
        $stmt->execute([$postId]);
        if (empty($tagIds)) {
            return;
        }
        $stmt = self::db()->prepare('INSERT INTO blog_post_tags (blog_post_id, tag_id) VALUES (?, ?)');
        foreach ($tagIds as $tagId) {
            $stmt->execute([$postId, (int) $tagId]);
        }
    }

    public static function adminList(int $page = 1, int $perPage = 20): array
    {
        $total = (int) self::db()->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        $pg = paginate($total, $page, $perPage);
        $sql = self::baseSelect() . " ORDER BY bp.created_at DESC LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        return ['items' => self::db()->query($sql)->fetchAll(), 'pagination' => $pg];
    }
}
