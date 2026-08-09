<?php
/** @var array $city */
/** @var array $areas */
ob_start();
?>
<a href="/admin/cities" style="font-size:13px;color:var(--admin-muted);display:inline-block;margin-bottom:14px;">&larr; Back to Cities</a>

<div class="toolbar">
    <div style="font-size:14px;color:var(--admin-muted);">Areas within <strong><?= e($city['name']) ?></strong></div>
    <button class="btn btn-primary" type="button" data-modal-open="addAreaModal">+ Add Area</button>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Area</th><th>Slug</th><th>Sort</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($areas as $a): ?>
            <tr>
                <td><?= e($a['name']) ?></td>
                <td style="color:var(--admin-muted);"><?= e($a['slug']) ?></td>
                <td><?= (int) $a['sort_order'] ?></td>
                <td><span class="badge <?= $a['is_active'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $a['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                <td class="row-actions">
                    <button class="icon-btn" type="button" data-modal-open="editAreaModal<?= (int) $a['id'] ?>" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </button>
                    <form method="post" action="/admin/cities/<?= (int) $city['id'] ?>/areas/<?= (int) $a['id'] ?>/delete" data-confirm="Delete this area?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$areas): ?><tr><td colspan="5">No areas yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="addAreaModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Add Area</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/cities/<?= (int) $city['id'] ?>/areas/store">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="0"></div>
                <label class="chip-check"><input type="checkbox" name="is_active" checked> Active</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add Area</button></div>
        </form>
    </div>
</div>

<?php foreach ($areas as $a): ?>
<div class="modal-backdrop" id="editAreaModal<?= (int) $a['id'] ?>">
    <div class="modal-box">
        <div class="modal-head"><h3>Edit Area</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/cities/<?= (int) $city['id'] ?>/areas/<?= (int) $a['id'] ?>/update">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($a['name']) ?>" required></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= (int) $a['sort_order'] ?>"></div>
                <label class="chip-check"><input type="checkbox" name="is_active" <?= $a['is_active'] ? 'checked' : '' ?>> Active</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Changes</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Areas — ' . $city['name'], 'active' => 'cities', 'content' => $content]);
