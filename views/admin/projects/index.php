<?php
/** @var array $items */
ob_start();
?>
<div class="toolbar">
    <div></div>
    <a class="btn btn-primary" href="/admin/projects/create">+ Add Project</a>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th></th><th>Name</th><th>City</th><th>Status</th><th>Starting Price</th><th>Featured</th><th>Published</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $p): ?>
            <?php $img = Project::images((int) $p['id'])[0]['path'] ?? null; ?>
            <tr>
                <td><img class="row-thumb" src="<?= e(media_url($img)) ?>" alt=""></td>
                <td><a href="/admin/projects/<?= (int) $p['id'] ?>/edit"><?= e($p['name']) ?></a></td>
                <td><?= e($p['city_name'] ?? '—') ?></td>
                <td><span class="badge badge-neutral"><?= e(ucfirst($p['status'])) ?></span></td>
                <td><?= $p['starting_price'] ? format_money($p['starting_price']) : '—' ?></td>
                <td>
                    <form method="post" action="/admin/projects/<?= (int) $p['id'] ?>/toggle-featured">
                        <?= Csrf::field() ?>
                        <button type="submit" class="badge <?= $p['is_featured'] ? 'badge-featured' : 'badge-neutral' ?>" style="border:none;cursor:pointer;"><?= $p['is_featured'] ? 'Featured' : 'Standard' ?></button>
                    </form>
                </td>
                <td>
                    <form method="post" action="/admin/projects/<?= (int) $p['id'] ?>/toggle-published">
                        <?= Csrf::field() ?>
                        <button type="submit" class="badge <?= $p['is_published'] ? 'badge-sale' : 'badge-neutral' ?>" style="border:none;cursor:pointer;"><?= $p['is_published'] ? 'Published' : 'Draft' ?></button>
                    </form>
                </td>
                <td class="row-actions">
                    <a class="icon-btn" href="/admin/projects/<?= (int) $p['id'] ?>/edit" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </a>
                    <form method="post" action="/admin/projects/<?= (int) $p['id'] ?>/delete" data-confirm="Delete this project?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="8">No projects yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Projects', 'active' => 'projects', 'content' => $content]);
