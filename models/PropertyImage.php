<?php
declare(strict_types=1);

class PropertyImage extends Model
{
    protected static string $table = 'property_images';

    public static function add(int $propertyId, int $mediaId, bool $isPrimary = false): int
    {
        if ($isPrimary) {
            self::clearPrimary($propertyId);
        }
        $stmt = self::db()->prepare('SELECT COALESCE(MAX(sort_order), 0) + 1 FROM property_images WHERE property_id = ?');
        $stmt->execute([$propertyId]);
        $nextOrder = (int) $stmt->fetchColumn();

        return self::insert([
            'property_id' => $propertyId,
            'media_id' => $mediaId,
            'sort_order' => $nextOrder,
            'is_primary' => $isPrimary ? 1 : 0,
        ]);
    }

    public static function clearPrimary(int $propertyId): void
    {
        $stmt = self::db()->prepare('UPDATE property_images SET is_primary = 0 WHERE property_id = ?');
        $stmt->execute([$propertyId]);
    }

    public static function setPrimary(int $id, int $propertyId): void
    {
        self::clearPrimary($propertyId);
        $stmt = self::db()->prepare('UPDATE property_images SET is_primary = 1 WHERE id = ? AND property_id = ?');
        $stmt->execute([$id, $propertyId]);
    }

    public static function reorder(array $orderedIds): void
    {
        $stmt = self::db()->prepare('UPDATE property_images SET sort_order = ? WHERE id = ?');
        foreach ($orderedIds as $index => $id) {
            $stmt->execute([$index, (int) $id]);
        }
    }
}
