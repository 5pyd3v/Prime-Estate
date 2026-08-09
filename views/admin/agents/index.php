<?php
/** @var array $items */
ob_start();
?>
<div class="toolbar">
    <div></div>
    <a class="btn btn-primary" href="/admin/agents/create">+ Add Agent</a>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th></th><th>Name</th><th>Designation</th><th>Phone</th><th>Properties</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $a): ?>
            <tr>
                <td><img class="row-thumb" style="border-radius:50%;" src="<?= e($a['photo_media_id'] ? media_url((Media::find((int) $a['photo_media_id'])['path'] ?? null)) : asset('images/placeholder.svg')) ?>" alt=""></td>
                <td><a href="/admin/agents/<?= (int) $a['id'] ?>/edit"><?= e($a['name']) ?></a></td>
                <td><?= e($a['designation'] ?? '') ?></td>
                <td><?= e($a['phone'] ?? '') ?></td>
                <td><?= Agent::propertyCount((int) $a['id']) ?></td>
                <td><span class="badge <?= $a['is_active'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $a['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                <td class="row-actions">
                    <a class="icon-btn" href="/admin/agents/<?= (int) $a['id'] ?>/edit" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </a>
                    <form method="post" action="/admin/agents/<?= (int) $a['id'] ?>/delete" data-confirm="Delete this agent?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="7">No agents yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Agents', 'active' => 'agents', 'content' => $content]);
