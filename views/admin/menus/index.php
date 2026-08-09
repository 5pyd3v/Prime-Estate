<?php
/** @var array $header */
/** @var array $footer */
ob_start();
function menu_table(array $items, string $location): void { ?>
    <div class="toolbar">
        <div></div>
        <button class="btn btn-primary btn-sm" type="button" data-modal-open="addMenu<?= $location ?>Modal">+ Add <?= ucfirst($location) ?> Item</button>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Label</th><th>URL</th><th>Sort</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($items as $m): ?>
                <tr>
                    <td><?= e($m['label']) ?></td>
                    <td style="color:var(--admin-muted);"><?= e($m['url']) ?></td>
                    <td><?= (int) $m['sort_order'] ?></td>
                    <td><span class="badge <?= $m['is_active'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $m['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                    <td class="row-actions">
                        <button class="icon-btn" type="button" data-modal-open="editMenu<?= (int) $m['id'] ?>Modal" title="Edit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                        </button>
                        <form method="post" action="/admin/menus/<?= (int) $m['id'] ?>/delete" data-confirm="Delete this menu item?" style="display:inline;">
                            <?= Csrf::field() ?>
                            <button class="icon-btn danger" type="submit" title="Delete">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$items): ?><tr><td colspan="5">No <?= $location ?> menu items yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="modal-backdrop" id="addMenu<?= $location ?>Modal">
        <div class="modal-box">
            <div class="modal-head"><h3>Add <?= ucfirst($location) ?> Menu Item</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
            <form method="post" action="/admin/menus/store">
                <div class="modal-body">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="location" value="<?= $location ?>">
                    <div class="form-group"><label class="form-label">Label</label><input class="form-control" name="label" required></div>
                    <div class="form-group"><label class="form-label">URL</label><input class="form-control" name="url" placeholder="/properties" required></div>
                    <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="0"></div>
                    <label class="chip-check"><input type="checkbox" name="is_active" checked> Active</label>
                </div>
                <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add Item</button></div>
            </form>
        </div>
    </div>

    <?php foreach ($items as $m): ?>
    <div class="modal-backdrop" id="editMenu<?= (int) $m['id'] ?>Modal">
        <div class="modal-box">
            <div class="modal-head"><h3>Edit Menu Item</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
            <form method="post" action="/admin/menus/<?= (int) $m['id'] ?>/update">
                <div class="modal-body">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="location" value="<?= e($m['location']) ?>">
                    <div class="form-group"><label class="form-label">Label</label><input class="form-control" name="label" value="<?= e($m['label']) ?>" required></div>
                    <div class="form-group"><label class="form-label">URL</label><input class="form-control" name="url" value="<?= e($m['url']) ?>" required></div>
                    <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= (int) $m['sort_order'] ?>"></div>
                    <label class="chip-check"><input type="checkbox" name="is_active" <?= $m['is_active'] ? 'checked' : '' ?>> Active</label>
                </div>
                <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Changes</button></div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
<?php }
?>
<div class="tab-bar" data-tabs="menuTabs">
    <a href="#" class="tab-link active" data-tab="header">Header Menu</a>
    <a href="#" class="tab-link" data-tab="footer">Footer Menu</a>
</div>
<div id="menuTabs">
    <div data-tab-panel="header"><?php menu_table($header, 'header'); ?></div>
    <div data-tab-panel="footer" style="display:none;"><?php menu_table($footer, 'footer'); ?></div>
</div>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Menus', 'active' => 'menus', 'content' => $content]);
