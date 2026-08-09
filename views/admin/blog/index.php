<?php
/** @var array $items */
/** @var array $pagination */
/** @var array $categories */
ob_start();
?>
<div class="toolbar">
    <button class="btn btn-secondary" type="button" data-modal-open="categoriesModal">Manage Categories</button>
    <a class="btn btn-primary" href="/admin/blog/create">+ Add Post</a>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th></th><th>Title</th><th>Category</th><th>Author</th><th>Status</th><th>Published</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $p): ?>
            <tr>
                <td><img class="row-thumb" src="<?= e($p['featured_image_id'] ? media_url((Media::find((int) $p['featured_image_id'])['path'] ?? null)) : asset('images/placeholder.svg')) ?>" alt=""></td>
                <td><a href="/admin/blog/<?= (int) $p['id'] ?>/edit"><?= e($p['title']) ?></a></td>
                <td><?= e($p['category_name'] ?? '—') ?></td>
                <td><?= e($p['author_name'] ?? '—') ?></td>
                <td><span class="badge <?= $p['status'] === 'published' ? 'badge-sale' : 'badge-neutral' ?>"><?= e(ucfirst($p['status'])) ?></span></td>
                <td><?= $p['published_at'] ? date('M j, Y', strtotime($p['published_at'])) : '—' ?></td>
                <td class="row-actions">
                    <a class="icon-btn" href="/admin/blog/<?= (int) $p['id'] ?>/edit" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </a>
                    <form method="post" action="/admin/blog/<?= (int) $p['id'] ?>/delete" data-confirm="Delete this post?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="7">No blog posts yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php if ($pagination['last_page'] > 1): ?>
<div class="admin-pagination">
    <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i === $pagination['current_page'] ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<div class="modal-backdrop" id="categoriesModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Blog Categories</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <div class="modal-body">
            <?php foreach ($categories as $c): ?>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--admin-border);">
                    <span><?= e($c['name']) ?></span>
                    <form method="post" action="/admin/blog/categories/<?= (int) $c['id'] ?>/delete" data-confirm="Delete this category?">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger btn-sm" type="submit">✕</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <?php if (!$categories): ?><p style="color:var(--admin-muted);font-size:13px;">No categories yet.</p><?php endif; ?>
            <form method="post" action="/admin/blog/categories/store" style="display:flex;gap:8px;margin-top:16px;">
                <?= Csrf::field() ?>
                <input class="form-control" name="name" placeholder="New category name" required>
                <button class="btn btn-primary btn-sm" type="submit">Add</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Blog', 'active' => 'blog', 'content' => $content]);
