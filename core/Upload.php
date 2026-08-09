<?php
declare(strict_types=1);

final class Upload
{
    private const ALLOWED = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png' => ['png'],
        'image/webp' => ['webp'],
        'application/pdf' => ['pdf'],
    ];

    /**
     * Validates and stores an uploaded file ($_FILES entry), returns the created media row id.
     */
    public static function handle(array $file, string $subdir = 'media', ?string $altText = null): int
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('Upload failed.');
        }

        $maxSize = (int) env('UPLOAD_MAX_SIZE', 8388608);
        if ($file['size'] > $maxSize) {
            throw new RuntimeException('File exceeds the maximum allowed size.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!isset(self::ALLOWED[$mime])) {
            throw new RuntimeException('Unsupported file type.');
        }

        $ext = self::ALLOWED[$mime][0];
        $isImage = str_starts_with($mime, 'image/');

        if ($isImage && @getimagesize($file['tmp_name']) === false) {
            throw new RuntimeException('File is not a valid image.');
        }

        $subdir = preg_replace('/[^a-z0-9_-]/i', '', $subdir) ?: 'media';
        $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        $relativePath = "{$subdir}/{$filename}";
        $destination = BASE_PATH . '/public/uploads/' . $relativePath;

        $destDir = dirname($destination);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException('Could not save uploaded file.');
        }

        return Media::insert([
            'filename' => $filename,
            'original_name' => basename($file['name']),
            'path' => $relativePath,
            'mime_type' => $mime,
            'file_type' => $mime === 'application/pdf' ? 'document' : 'image',
            'size' => (int) $file['size'],
            'alt_text' => $altText,
            'uploaded_by' => Auth::id(),
        ]);
    }
}
