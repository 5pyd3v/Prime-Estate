<?php
declare(strict_types=1);

class Page extends Model
{
    protected static string $table = 'pages';

    public static function bySlug(string $slug): ?array
    {
        return self::findBy('slug', $slug);
    }
}
