<?php
/** @var array $items */
ob_start();
?>
<div class="toolbar">
    <div></div>
    <button class="btn btn-primary" type="button" data-modal-open="addTypeModal">+ Add Property Type</button>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Name</th><th>Slug</th><th>Sort</th><th>Status</th><th>Properties</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $t): ?>
            <tr>
                <td><?= e($t['name']) ?></td>
                <td style="color:var(--admin-muted);"><?= e($t['slug']) ?></td>
                <td><?= (int) $t['sort_order'] ?></td>
                <td><span class="badge <?= $t['is_active'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $t['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                <td><?= (int) DB::connection()->query('SELECT COUNT(*) FROM properties WHERE property_type_id = ' . (int) $t['id'])->fetchColumn() ?></td>
                <td class="row-actions">
                    <button class="icon-btn" type="button" data-modal-open="editTypeModal<?= (int) $t['id'] ?>" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </button>
                    <form method="post" action="/admin/property-types/<?= (int) $t['id'] ?>/delete" data-confirm="Delete this property type?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="6">No property types yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal-backdrop" id="addTypeModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Add Property Type</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/property-types/store">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                <div class="form-group"><label class="form-label">Icon keyword</label><input class="form-control" name="icon" placeholder="home"></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="0"></div>
                <label class="chip-check"><input type="checkbox" name="is_active" checked> Active</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add Type</button></div>
        </form>
    </div>
</div>

<!-- Edit Modals -->
<?php foreach ($items as $t): ?>
<div class="modal-backdrop" id="editTypeModal<?= (int) $t['id'] ?>">
    <div class="modal-box">
        <div class="modal-head"><h3>Edit Property Type</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/property-types/<?= (int) $t['id'] ?>/update">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($t['name']) ?>" required></div>
                <div class="form-group"><label class="form-label">Icon keyword</label><input class="form-control" name="icon" value="<?= e($t['icon'] ?? '') ?>"></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= (int) $t['sort_order'] ?>"></div>
                <label class="chip-check"><input type="checkbox" name="is_active" <?= $t['is_active'] ? 'checked' : '' ?>> Active</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Changes</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Property Types', 'active' => 'property-types', 'content' => $content]);
