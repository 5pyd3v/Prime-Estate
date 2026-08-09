<?php
declare(strict_types=1);

class Media extends Model
{
    protected static string $table = 'media';

    public static function recent(int $limit = 60, string $type = ''): array
    {
        $sql = 'SELECT * FROM media';
        $params = [];
        if ($type !== '') {
            $sql .= ' WHERE file_type = ?';
            $params[] = $type;
        }
        $sql .= ' ORDER BY id DESC LIMIT ' . (int) $limit;
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function search(string $term, int $limit = 60): array
    {
        $stmt = self::db()->prepare('SELECT * FROM media WHERE original_name LIKE ? OR alt_text LIKE ? ORDER BY id DESC LIMIT ' . (int) $limit);
        $like = '%' . $term . '%';
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }
}
