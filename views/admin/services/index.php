<?php
/** @var array $items */
ob_start();
?>
<div class="toolbar">
    <div></div>
    <button class="btn btn-primary" type="button" data-modal-open="addServiceModal">+ Add Service</button>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Title</th><th>Short Description</th><th>Sort</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $s): ?>
            <tr>
                <td><?= e($s['title']) ?></td>
                <td style="color:var(--admin-muted);max-width:340px;"><?= e(mb_strimwidth($s['short_description'] ?? '', 0, 80, '…')) ?></td>
                <td><?= (int) $s['sort_order'] ?></td>
                <td><span class="badge <?= $s['is_published'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $s['is_published'] ? 'Published' : 'Draft' ?></span></td>
                <td class="row-actions">
                    <button class="icon-btn" type="button" data-modal-open="editServiceModal<?= (int) $s['id'] ?>" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </button>
                    <form method="post" action="/admin/services/<?= (int) $s['id'] ?>/delete" data-confirm="Delete this service?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="5">No services yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="addServiceModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Add Service</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/services/store">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Title</label><input class="form-control" name="title" required></div>
                <div class="form-group"><label class="form-label">Icon keyword</label><input class="form-control" name="icon" placeholder="home"></div>
                <div class="form-group"><label class="form-label">Short Description</label><textarea class="form-control" name="short_description"></textarea></div>
                <div class="form-group"><label class="form-label">Full Description</label><textarea class="form-control" name="description"></textarea></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="0"></div>
                <label class="chip-check"><input type="checkbox" name="is_published" checked> Published</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add Service</button></div>
        </form>
    </div>
</div>

<?php foreach ($items as $s): ?>
<div class="modal-backdrop" id="editServiceModal<?= (int) $s['id'] ?>">
    <div class="modal-box">
        <div class="modal-head"><h3>Edit Service</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/services/<?= (int) $s['id'] ?>/update">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Title</label><input class="form-control" name="title" value="<?= e($s['title']) ?>" required></div>
                <div class="form-group"><label class="form-label">Icon keyword</label><input class="form-control" name="icon" value="<?= e($s['icon'] ?? '') ?>"></div>
                <div class="form-group"><label class="form-label">Short Description</label><textarea class="form-control" name="short_description"><?= e($s['short_description'] ?? '') ?></textarea></div>
                <div class="form-group"><label class="form-label">Full Description</label><textarea class="form-control" name="description"><?= e($s['description'] ?? '') ?></textarea></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= (int) $s['sort_order'] ?>"></div>
                <label class="chip-check"><input type="checkbox" name="is_published" <?= $s['is_published'] ? 'checked' : '' ?>> Published</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Changes</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Services', 'active' => 'services', 'content' => $content]);
