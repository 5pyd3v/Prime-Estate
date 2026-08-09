<?php
/** @var array $items */
ob_start();
?>
<div class="toolbar">
    <div></div>
    <button class="btn btn-primary" type="button" data-modal-open="addCityModal">+ Add City</button>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>City</th><th>Slug</th><th>Areas</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $c): ?>
            <tr>
                <td><?= e($c['name']) ?></td>
                <td style="color:var(--admin-muted);"><?= e($c['slug']) ?></td>
                <td><a href="/admin/cities/<?= (int) $c['id'] ?>/areas"><?= (int) $c['area_count'] ?> areas</a></td>
                <td><span class="badge <?= $c['is_active'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $c['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                <td class="row-actions">
                    <a class="icon-btn" href="/admin/cities/<?= (int) $c['id'] ?>/areas" title="Manage Areas">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
                    </a>
                    <button class="icon-btn" type="button" data-modal-open="editCityModal<?= (int) $c['id'] ?>" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </button>
                    <form method="post" action="/admin/cities/<?= (int) $c['id'] ?>/delete" data-confirm="Delete this city and all its areas?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="5">No cities yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="addCityModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Add City</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/cities/store">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="0"></div>
                <label class="chip-check"><input type="checkbox" name="is_active" checked> Active</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add City</button></div>
        </form>
    </div>
</div>

<?php foreach ($items as $c): ?>
<div class="modal-backdrop" id="editCityModal<?= (int) $c['id'] ?>">
    <div class="modal-box">
        <div class="modal-head"><h3>Edit City</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/cities/<?= (int) $c['id'] ?>/update">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($c['name']) ?>" required></div>
                <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= (int) $c['sort_order'] ?>"></div>
                <label class="chip-check"><input type="checkbox" name="is_active" <?= $c['is_active'] ? 'checked' : '' ?>> Active</label>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Changes</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Cities & Areas', 'active' => 'cities', 'content' => $content]);
