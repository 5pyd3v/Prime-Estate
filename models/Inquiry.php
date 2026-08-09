<?php
declare(strict_types=1);

class Inquiry extends Model
{
    protected static string $table = 'inquiries';

    public static function adminList(array $filters, int $page = 1, int $perPage = 20): array
    {
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['status'])) {
            $where[] = 'i.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['type'])) {
            $where[] = 'i.inquiry_type = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['q'])) {
            $where[] = '(i.name LIKE ? OR i.phone LIKE ? OR i.email LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            array_push($params, $like, $like, $like);
        }

        $whereSql = implode(' AND ', $where);
        $countStmt = self::db()->prepare('SELECT COUNT(*) FROM inquiries i WHERE ' . $whereSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();
        $pg = paginate($total, $page, $perPage);

        $sql = "SELECT i.*, p.title AS property_title, p.slug AS property_slug, pr.name AS project_name, pr.slug AS project_slug
                FROM inquiries i
                LEFT JOIN properties p ON p.id = i.property_id
                LEFT JOIN projects pr ON pr.id = i.project_id
                WHERE {$whereSql}
                ORDER BY i.created_at DESC LIMIT {$pg['per_page']} OFFSET {$pg['offset']}";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'pagination' => $pg];
    }

    public static function countNew(): int
    {
        return (int) self::db()->query("SELECT COUNT(*) FROM inquiries WHERE status = 'new'")->fetchColumn();
    }
}
