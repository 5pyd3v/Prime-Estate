<?php
declare(strict_types=1);

function admin_media_index(): void
{
    Auth::require();
    $q = trim((string) input('q', ''));
    $items = $q !== '' ? Media::search($q, 100) : Media::recent(100);
    view('admin/media/index', ['title' => 'Media Library', 'active' => 'media', 'items' => $items, 'q' => $q]);
}

function admin_media_picker_list(): void
{
    Auth::require();
    $q = trim((string) input('q', ''));
    $type = trim((string) input('type', ''));
    $items = $q !== '' ? Media::search($q, 80) : Media::recent(80, $type);
    json_response(['items' => array_map('media_json', $items)]);
}

function media_json(array $m): array
{
    return [
        'id' => (int) $m['id'],
        'url' => media_url($m['path']),
        'name' => $m['original_name'],
        'type' => $m['file_type'],
        'alt' => $m['alt_text'],
    ];
}

function admin_media_upload(): void
{
    Auth::require();
    Csrf::verifyRequest();

    if (empty($_FILES['file'])) {
        json_response(['error' => 'No file received.'], 422);
    }

    try {
        $id = Upload::handle($_FILES['file'], 'media', (string) input('alt_text', ''));
        $media = Media::find($id);
        json_response(['item' => media_json($media)]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
}

function admin_media_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();

    $media = Media::find($id);
    if ($media) {
        $path = BASE_PATH . '/public/uploads/' . $media['path'];
        if (is_file($path)) {
            @unlink($path);
        }
        Media::delete($id);
    }

    if (str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')) {
        json_response(['ok' => true]);
    }
    flash('success', 'File deleted.');
    redirect('/admin/media');
}

function admin_media_update_alt(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Media::update($id, ['alt_text' => (string) input('alt_text', '')]);
    flash('success', 'Updated.');
    redirect('/admin/media');
}
