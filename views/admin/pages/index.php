<?php
/** @var array $items */
ob_start();
?>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Page</th><th>Slug</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $p): ?>
            <tr>
                <td><?= e($p['title']) ?></td>
                <td style="color:var(--admin-muted);">/<?= e($p['slug']) ?></td>
                <td><span class="badge <?= $p['status'] === 'published' ? 'badge-sale' : 'badge-neutral' ?>"><?= e(ucfirst($p['status'])) ?></span></td>
                <td class="row-actions">
                    <a class="icon-btn" href="/admin/pages/<?= (int) $p['id'] ?>/edit" title="Manage Sections">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Pages', 'active' => 'pages', 'content' => $content]);
