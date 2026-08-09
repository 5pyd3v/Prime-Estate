<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string
{
    $base = rtrim((string) env('APP_URL', ''), '/');
    return $base . '/' . ltrim($path, '/');
}

function url(string $path = ''): string
{
    return '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

function media_url(?string $path): string
{
    if ($path === null || $path === '') {
        return asset('images/placeholder.svg');
    }
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }
    return '/uploads/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function current_path(): string
{
    return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
}

function slugify(string $text): string
{
    $text = trim($text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text) ?? $text;
    $text = iconv('utf-8', 'ascii//TRANSLIT//IGNORE', $text) ?: $text;
    $text = preg_replace('~[^-\w]+~', '', $text) ?? $text;
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text) ?? $text;
    $text = strtolower($text);

    return $text === '' ? 'n-a' : $text;
}

function slug_for_update(string $table, int $id, string $newName, ?array $existing): string
{
    if ($existing && $existing['name'] === $newName) {
        return $existing['slug'];
    }
    return unique_slug(function ($candidate) use ($table, $id) {
        $stmt = DB::connection()->prepare("SELECT id FROM {$table} WHERE slug = ? AND id != ?");
        $stmt->execute([$candidate, $id]);
        return (bool) $stmt->fetchColumn();
    }, $newName);
}

function unique_slug(callable $exists, string $base, ?int $ignoreId = null): string
{
    $slug = slugify($base);
    $original = $slug;
    $i = 1;
    while ($exists($slug, $ignoreId)) {
        $slug = $original . '-' . (++$i);
    }
    return $slug;
}

function format_money(float|int|string $amount, string $currency = 'PKR'): string
{
    $amount = (float) $amount;

    if ($amount >= 10000000) {
        $formatted = rtrim(rtrim(number_format($amount / 10000000, 2), '0'), '.');
        return "{$currency} {$formatted} Crore";
    }
    if ($amount >= 100000) {
        $formatted = rtrim(rtrim(number_format($amount / 100000, 2), '0'), '.');
        return "{$currency} {$formatted} Lakh";
    }

    return $currency . ' ' . number_format($amount);
}

function whatsapp_link(string $number, string $message = ''): string
{
    $number = preg_replace('/[^0-9]/', '', $number) ?? '';
    $url = 'https://wa.me/' . $number;
    if ($message !== '') {
        $url .= '?text=' . rawurlencode($message);
    }
    return $url;
}

function tel_link(string $number): string
{
    return 'tel:' . preg_replace('/\s+/', '', $number);
}

function truncate(string $text, int $length = 150): string
{
    $text = trim(strip_tags($text));
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '…';
}

function time_ago(string $datetime): string
{
    $diff = time() - strtotime($datetime);
    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hr ago';
    if ($diff < 2592000) return floor($diff / 86400) . ' days ago';
    return date('M j, Y', strtotime($datetime));
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['_old'][$key] ?? $default);
}

function flash(string $type, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$type] = $message;
        return null;
    }
    $value = $_SESSION['_flash'][$type] ?? null;
    unset($_SESSION['_flash'][$type]);
    return $value;
}

function input(string $key, mixed $default = null): mixed
{
    return $_POST[$key] ?? $_GET[$key] ?? $default;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function paginate(int $total, int $page, int $perPage): array
{
    $lastPage = max(1, (int) ceil($total / $perPage));
    $page = max(1, min($page, $lastPage));

    return [
        'total' => $total,
        'per_page' => $perPage,
        'current_page' => $page,
        'last_page' => $lastPage,
        'offset' => ($page - 1) * $perPage,
    ];
}

function query_string_with(array $overrides): string
{
    $params = array_merge($_GET, $overrides);
    foreach ($params as $k => $v) {
        if ($v === null || $v === '') {
            unset($params[$k]);
        }
    }
    return http_build_query($params);
}

function view(string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require BASE_PATH . '/views/' . $view . '.php';
}

function view_capture(string $view, array $data = []): string
{
    ob_start();
    view($view, $data);
    return (string) ob_get_clean();
}

function abort(int $code): never
{
    http_response_code($code);
    $map = [404 => 'pages/404', 403 => 'pages/403', 500 => 'pages/500'];
    view($map[$code] ?? 'pages/404');
    exit;
}

function media_picker_field(string $name, int $currentId = 0, string $type = 'image', string $label = ''): string
{
    $url = $currentId ? media_url((Media::find($currentId)['path'] ?? null)) : '';
    $hasImage = $url !== '';
    ob_start();
    ?>
    <div class="media-field" data-media-field data-type="<?= e($type) ?>">
        <?php if ($label): ?><label class="form-label"><?= e($label) ?></label><?php endif; ?>
        <div class="media-field-preview" style="width:120px;height:90px;border-radius:10px;overflow:hidden;background:#F1F2F5;display:flex;align-items:center;justify-content:center;border:1px solid var(--admin-border, #E7E4DC);">
            <img src="<?= e($url) ?>" class="media-field-img" style="width:100%;height:100%;object-fit:cover;<?= $hasImage ? '' : 'display:none;' ?>">
            <span class="media-field-empty" style="font-size:11px;color:#999;<?= $hasImage ? 'display:none;' : '' ?>">No file</span>
        </div>
        <input type="hidden" name="<?= e($name) ?>" value="<?= (int) $currentId ?>" class="media-field-input">
        <div style="display:flex;gap:8px;margin-top:8px;">
            <button type="button" class="btn btn-secondary btn-sm" data-media-choose>Choose</button>
            <button type="button" class="btn btn-secondary btn-sm" data-media-clear>Remove</button>
        </div>
    </div>
    <?php
    return (string) ob_get_clean();
}

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
