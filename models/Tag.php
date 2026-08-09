<?php
declare(strict_types=1);

class Tag extends Model
{
    protected static string $table = 'tags';

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }

    public static function findOrCreateByNames(array $names): array
    {
        $ids = [];
        foreach ($names as $name) {
            $name = trim($name);
            if ($name === '') {
                continue;
            }
            $slug = slugify($name);
            $existing = self::findBy('slug', $slug);
            $ids[] = $existing ? (int) $existing['id'] : self::insert(['name' => $name, 'slug' => $slug]);
        }
        return $ids;
    }
}
