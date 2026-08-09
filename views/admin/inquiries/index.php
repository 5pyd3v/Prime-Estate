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
            <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="Search name, phone, email…">
        </div>
        <select name="type">
            <option value="">All Types</option>
            <?php foreach (['details', 'visit', 'whatsapp', 'call', 'general'] as $t): ?>
                <option value="<?= $t ?>" <?= $filters['type'] === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status">
            <option value="">All Statuses</option>
            <?php foreach (['new', 'contacted', 'closed'] as $s): ?>
                <option value="<?= $s ?>" <?= $filters['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-secondary btn-sm" type="submit">Filter</button>
    </form>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Name</th><th>Contact</th><th>Regarding</th><th>Type</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $i): ?>
            <tr>
                <td><?= e($i['name']) ?></td>
                <td><?= e($i['phone'] ?? '') ?><?= $i['email'] ? '<br>' . e($i['email']) : '' ?></td>
                <td><?= e($i['property_title'] ?? $i['project_name'] ?? 'General') ?></td>
                <td><span class="badge badge-neutral"><?= e(ucfirst($i['inquiry_type'])) ?></span></td>
                <td>
                    <form method="post" action="/admin/inquiries/<?= (int) $i['id'] ?>/status" style="display:inline;">
                        <?= Csrf::field() ?>
                        <select name="status" class="form-control" style="padding:5px 8px;font-size:12px;" onchange="this.form.submit()">
                            <?php foreach (['new', 'contacted', 'closed'] as $s): ?>
                                <option value="<?= $s ?>" <?= $i['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td style="font-size:12px;color:var(--admin-muted);"><?= time_ago($i['created_at']) ?></td>
                <td class="row-actions">
                    <form method="post" action="/admin/inquiries/<?= (int) $i['id'] ?>/delete" data-confirm="Delete this inquiry?">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="7">No inquiries found.</td></tr><?php endif; ?>
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
view('layouts/admin-shell', ['title' => 'Inquiries', 'active' => 'inquiries', 'content' => $content]);
