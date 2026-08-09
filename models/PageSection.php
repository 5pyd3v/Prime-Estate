<?php
declare(strict_types=1);

class PageSection extends Model
{
    protected static string $table = 'page_sections';

    public static function forPage(int $pageId, bool $activeOnly = true): array
    {
        $sql = 'SELECT * FROM page_sections WHERE page_id = ?';
        if ($activeOnly) {
            $sql .= ' AND is_active = 1';
        }
        $sql .= ' ORDER BY sort_order';
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$pageId]);
        return $stmt->fetchAll();
    }

    public static function reorder(array $orderedIds): void
    {
        $stmt = self::db()->prepare('UPDATE page_sections SET sort_order = ? WHERE id = ?');
        foreach ($orderedIds as $index => $id) {
            $stmt->execute([$index, (int) $id]);
        }
    }
}
