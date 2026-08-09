<?php
/** @var array $items */
/** @var string $q */
ob_start();
?>
<div class="toolbar">
    <form method="get" class="search-input">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search media…">
    </form>
    <button class="btn btn-primary" type="button" id="openUploadBtn">Upload File</button>
</div>

<input type="file" id="pageUploadInput" accept="image/jpeg,image/png,image/webp,application/pdf" style="display:none;">

<div class="media-grid" id="pageMediaGrid" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
    <?php foreach ($items as $m): ?>
        <div class="panel" style="padding:0;overflow:hidden;">
            <div style="aspect-ratio:1;background:#F1F2F5;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                <?php if ($m['file_type'] === 'image'): ?>
                    <img src="<?= e(media_url($m['path'])) ?>" alt="<?= e($m['alt_text'] ?? '') ?>" style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                    <span style="font-size:12px;color:#999;padding:10px;text-align:center;"><?= e($m['original_name']) ?></span>
                <?php endif; ?>
            </div>
            <div style="padding:10px;">
                <div style="font-size:11.5px;color:var(--admin-muted);word-break:break-all;margin-bottom:8px;" title="<?= e($m['original_name']) ?>">
                    <?= e(mb_strimwidth($m['original_name'], 0, 22, '…')) ?>
                </div>
                <form method="post" action="/admin/media/<?= (int) $m['id'] ?>/delete" data-confirm="Delete this file permanently?">
                    <?= Csrf::field() ?>
                    <button class="btn btn-secondary btn-sm btn-block" type="submit">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (!$items): ?><p style="color:var(--admin-muted);">No media files found.</p><?php endif; ?>
</div>

<script>
document.getElementById('openUploadBtn').addEventListener('click', function () {
    document.getElementById('pageUploadInput').click();
});
document.getElementById('pageUploadInput').addEventListener('change', function (e) {
    if (!e.target.files[0]) return;
    var fd = new FormData();
    fd.append('file', e.target.files[0]);
    fd.append('_csrf', document.getElementById('csrfToken').value);
    fetch('/admin/media/upload', { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.item) { showToast('File uploaded', 'success'); location.reload(); }
            else if (data.error) { showToast(data.error, 'error'); }
        });
});
</script>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Media Library', 'active' => 'media', 'content' => $content]);
