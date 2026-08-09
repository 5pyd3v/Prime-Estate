<?php
declare(strict_types=1);

class ContactMessage extends Model
{
    protected static string $table = 'contact_messages';

    public static function adminList(array $filters, int $page = 1, int $perPage = 20): array
    {
        $where = ['1=1'];
        $params = [];

        if (isset($filters['is_read']) && $filters['is_read'] !== '') {
            $where[] = 'is_read = ?';
            $params[] = (int) $filters['is_read'];
        }
        if (!empty($filters['q'])) {
            $where[] = '(name LIKE ? OR email LIKE ? OR message LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            array_push($params, $like, $like, $like);
        }

        $whereSql = implode(' AND ', $where);
        $countStmt = self::db()->prepare('SELECT COUNT(*) FROM contact_messages WHERE ' . $whereSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();
        $pg = paginate($total, $page, $perPage);

        $sql = "SELECT * FROM contact_messages WHERE {$whereSql} ORDER BY created_at DESC LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'pagination' => $pg];
    }

    public static function countUnread(): int
    {
        return (int) self::db()->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();
    }
}
