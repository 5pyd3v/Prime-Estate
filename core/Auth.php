<?php
declare(strict_types=1);

final class Auth
{
    private const SESSION_KEY = '_admin_user_id';
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_MINUTES = 15;

    public static function attempt(string $email, string $password): bool
    {
        if (self::isThrottled($email)) {
            return false;
        }

        $user = User::findBy('email', $email);
        self::recordAttempt($email);

        if (!$user || $user['status'] !== 'active' || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        self::clearAttempts($email);
        session_regenerate_id(true);
        $_SESSION[self::SESSION_KEY] = (int) $user['id'];
        User::update((int) $user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);

        return true;
    }

    private static function isThrottled(string $email): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $stmt = DB::connection()->prepare(
            'SELECT COUNT(*) FROM login_attempts WHERE email = ? AND ip_address = ? AND attempted_at > (NOW() - INTERVAL ? MINUTE)'
        );
        $stmt->execute([$email, $ip, self::LOCKOUT_MINUTES]);
        return (int) $stmt->fetchColumn() >= self::MAX_ATTEMPTS;
    }

    private static function recordAttempt(string $email): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $stmt = DB::connection()->prepare('INSERT INTO login_attempts (email, ip_address) VALUES (?, ?)');
        $stmt->execute([$email, $ip]);
    }

    private static function clearAttempts(string $email): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $stmt = DB::connection()->prepare('DELETE FROM login_attempts WHERE email = ? AND ip_address = ?');
        $stmt->execute([$email, $ip]);
    }

    public static function check(): bool
    {
        return isset($_SESSION[self::SESSION_KEY]);
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        static $cached = null;
        if ($cached === null) {
            $cached = User::find((int) $_SESSION[self::SESSION_KEY]) ?: false;
        }
        return $cached ?: null;
    }

    public static function id(): ?int
    {
        return $_SESSION[self::SESSION_KEY] ?? null;
    }

    public static function role(): ?string
    {
        return self::user()['role'] ?? null;
    }

    public static function can(string $capability): bool
    {
        $role = self::role();
        if ($role === 'super_admin') {
            return true;
        }
        $restricted = ['manage_users', 'manage_settings'];
        if (in_array($capability, $restricted, true)) {
            return $role === 'admin' && $capability !== 'manage_users';
        }
        return $role === 'admin' || $role === 'editor';
    }

    public static function require(): void
    {
        if (!self::check()) {
            redirect('/admin/login');
        }
    }

    public static function requireRole(string ...$roles): void
    {
        self::require();
        if (!in_array(self::role(), $roles, true)) {
            abort(403);
        }
    }

    public static function logout(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
        session_regenerate_id(true);
    }
}
