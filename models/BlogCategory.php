<?php
declare(strict_types=1);

class BlogCategory extends Model
{
    protected static string $table = 'blog_categories';

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }

    public static function withCounts(): array
    {
        $sql = 'SELECT bc.*, COUNT(bp.id) AS post_count
                FROM blog_categories bc
                LEFT JOIN blog_posts bp ON bp.category_id = bc.id AND bp.status = "published"
                GROUP BY bc.id ORDER BY bc.name';
        return self::db()->query($sql)->fetchAll();
    }
}
