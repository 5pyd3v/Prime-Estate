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
            <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="Search name, email, message…">
        </div>
        <select name="is_read">
            <option value="">All Messages</option>
            <option value="0" <?= $filters['is_read'] === '0' ? 'selected' : '' ?>>Unread</option>
            <option value="1" <?= $filters['is_read'] === '1' ? 'selected' : '' ?>>Read</option>
        </select>
        <button class="btn btn-secondary btn-sm" type="submit">Filter</button>
    </form>
</div>

<?php foreach ($items as $m): ?>
    <div class="panel" style="<?= $m['is_read'] ? '' : 'border-left:3px solid var(--admin-primary);' ?>">
        <div style="display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <strong><?= e($m['name']) ?></strong>
                    <?php if (!$m['is_read']): ?><span class="badge badge-new">New</span><?php endif; ?>
                    <?php if ($m['is_contacted']): ?><span class="badge badge-sale">Contacted</span><?php endif; ?>
                </div>
                <div style="font-size:12.5px;color:var(--admin-muted);margin-top:2px;">
                    <?= e($m['email']) ?><?= $m['phone'] ? ' · ' . e($m['phone']) : '' ?> · <?= time_ago($m['created_at']) ?>
                </div>
                <?php if ($m['subject']): ?><div style="font-weight:600;margin-top:10px;font-size:13.5px;"><?= e($m['subject']) ?></div><?php endif; ?>
                <p style="margin-top:6px;font-size:13.5px;color:#333;"><?= nl2br(e($m['message'])) ?></p>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;min-width:140px;">
                <?php if (!$m['is_read']): ?>
                    <form method="post" action="/admin/messages/<?= (int) $m['id'] ?>/read"><?= Csrf::field() ?><button class="btn btn-secondary btn-sm btn-block" type="submit">Mark Read</button></form>
                <?php else: ?>
                    <form method="post" action="/admin/messages/<?= (int) $m['id'] ?>/unread"><?= Csrf::field() ?><button class="btn btn-secondary btn-sm btn-block" type="submit">Mark Unread</button></form>
                <?php endif; ?>
                <?php if (!$m['is_contacted']): ?>
                    <form method="post" action="/admin/messages/<?= (int) $m['id'] ?>/contacted"><?= Csrf::field() ?><button class="btn btn-primary btn-sm btn-block" type="submit">Mark Contacted</button></form>
                <?php endif; ?>
                <form method="post" action="/admin/messages/<?= (int) $m['id'] ?>/delete" data-confirm="Delete this message?"><?= Csrf::field() ?><button class="btn btn-secondary btn-sm btn-block" type="submit" style="color:var(--color-danger);">Delete</button></form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php if (!$items): ?><p style="color:var(--admin-muted);">No contact messages found.</p><?php endif; ?>

<?php if ($pagination['last_page'] > 1): ?>
<div class="admin-pagination">
    <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
        <a href="?<?= query_string_with(['page' => $i]) ?>" class="<?= $i === $pagination['current_page'] ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Contact Messages', 'active' => 'messages', 'content' => $content]);
