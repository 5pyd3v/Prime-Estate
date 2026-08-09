<?php
/** @var array $items */
/** @var array $pagination */
/** @var array $filters */
ob_start();
?>
<div class="toolbar">
    <form class="filter-bar" method="get">
        <div class="search-input">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
            <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="Search title…">
        </div>
        <select name="purpose">
            <option value="">All Purposes</option>
            <option value="sale" <?= $filters['purpose'] === 'sale' ? 'selected' : '' ?>>Sale</option>
            <option value="rent" <?= $filters['purpose'] === 'rent' ? 'selected' : '' ?>>Rent</option>
        </select>
        <select name="status">
            <option value="">All Statuses</option>
            <?php foreach (['available', 'sold', 'rented', 'under_offer'] as $st): ?>
                <option value="<?= $st ?>" <?= $filters['status'] === $st ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $st)) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="published">
            <option value="">Published & Draft</option>
            <option value="1" <?= $filters['published'] === '1' ? 'selected' : '' ?>>Published Only</option>
            <option value="0" <?= $filters['published'] === '0' ? 'selected' : '' ?>>Draft Only</option>
        </select>
        <button class="btn btn-secondary btn-sm" type="submit">Filter</button>
    </form>
    <a class="btn btn-primary" href="/admin/properties/create">+ Add Property</a>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th></th><th>Title</th><th>Type</th><th>Purpose</th><th>Price</th><th>Status</th><th>Featured</th><th>Published</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $p): ?>
            <tr>
                <td><img class="row-thumb" src="<?= e(media_url($p['primary_image'] ?? null)) ?>" alt=""></td>
                <td>
                    <a href="/admin/properties/<?= (int) $p['id'] ?>/edit"><?= e($p['title']) ?></a>
                    <div style="font-size:11.5px;color:var(--admin-muted);"><?= e($p['city_name'] ?? '—') ?></div>
                </td>
                <td><?= e($p['type_name'] ?? '—') ?></td>
                <td><span class="badge badge-<?= e($p['purpose']) ?>"><?= e(ucfirst($p['purpose'])) ?></span></td>
                <td><?= format_money($p['price'], $p['currency']) ?><?= $p['price_label'] ? ' ' . e($p['price_label']) : '' ?></td>
                <td>
                    <form method="post" action="/admin/properties/<?= (int) $p['id'] ?>/status" style="display:inline;">
                        <?= Csrf::field() ?>
                        <select name="status" class="form-control" style="padding:5px 8px;font-size:12px;" onchange="this.form.submit()">
                            <?php foreach (['available', 'sold', 'rented', 'under_offer'] as $st): ?>
                                <option value="<?= $st ?>" <?= $p['status'] === $st ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $st)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td>
                    <form method="post" action="/admin/properties/<?= (int) $p['id'] ?>/toggle-featured">
                        <?= Csrf::field() ?>
                        <button type="submit" class="badge <?= $p['is_featured'] ? 'badge-featured' : 'badge-neutral' ?>" style="border:none;cursor:pointer;"><?= $p['is_featured'] ? 'Featured' : 'Standard' ?></button>
                    </form>
                </td>
                <td>
                    <form method="post" action="/admin/properties/<?= (int) $p['id'] ?>/toggle-published">
                        <?= Csrf::field() ?>
                        <button type="submit" class="badge <?= $p['is_published'] ? 'badge-sale' : 'badge-neutral' ?>" style="border:none;cursor:pointer;"><?= $p['is_published'] ? 'Published' : 'Draft' ?></button>
                    </form>
                </td>
                <td class="row-actions">
                    <a class="icon-btn" href="/admin/properties/<?= (int) $p['id'] ?>/edit" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </a>
                    <form method="post" action="/admin/properties/<?= (int) $p['id'] ?>/duplicate" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn" type="submit" title="Duplicate">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                        </button>
                    </form>
                    <form method="post" action="/admin/properties/<?= (int) $p['id'] ?>/delete" data-confirm="Delete this property permanently?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="9">No properties found.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pagination['last_page'] > 1): ?>
<div class="admin-pagination">
    <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
        <a href="?<?= query_string_with(['page' => $i]) ?>" class="<?= $i === $pagination['current_page'] ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Properties', 'active' => 'properties', 'content' => $content]);
