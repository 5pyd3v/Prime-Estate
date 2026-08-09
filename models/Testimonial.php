<?php
declare(strict_types=1);

class Testimonial extends Model
{
    protected static string $table = 'testimonials';

    public static function published(int $limit = 0, bool $featuredOnly = false): array
    {
        $sql = 'SELECT * FROM testimonials WHERE is_published = 1';
        if ($featuredOnly) {
            $sql .= ' AND is_featured = 1';
        }
        $sql .= ' ORDER BY sort_order, id DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        return self::db()->query($sql)->fetchAll();
    }
}
