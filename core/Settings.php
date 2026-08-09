<?php
declare(strict_types=1);

final class Settings
{
    private static array $cache = [];
    private static bool $booted = false;

    public static function boot(): void
    {
        if (self::$booted) {
            return;
        }
        try {
            $stmt = DB::connection()->query('SELECT setting_key, setting_value FROM settings');
            foreach ($stmt->fetchAll() as $row) {
                self::$cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable $e) {
            error_log('Settings boot failed: ' . $e->getMessage());
        }
        self::$booted = true;
    }

    public static function get(string $key, mixed $default = ''): mixed
    {
        self::boot();
        return self::$cache[$key] ?? $default;
    }

    public static function all(): array
    {
        self::boot();
        return self::$cache;
    }

    public static function set(string $key, string $value, string $group = 'general'): void
    {
        $stmt = DB::connection()->prepare(
            'INSERT INTO settings (setting_key, setting_value, setting_group) VALUES (:k, :v, :g)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_group = VALUES(setting_group)'
        );
        $stmt->execute(['k' => $key, 'v' => $value, 'g' => $group]);
        self::$cache[$key] = $value;
    }

    public static function setMany(array $pairs, string $group = 'general'): void
    {
        foreach ($pairs as $key => $value) {
            self::set($key, (string) $value, $group);
        }
    }

    public static function media(string $key): string
    {
        $mediaId = (int) self::get($key, 0);
        if ($mediaId <= 0) {
            return '';
        }
        $media = Media::find($mediaId);
        return $media ? media_url($media['path']) : '';
    }
}
