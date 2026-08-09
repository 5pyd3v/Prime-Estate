<?php
/** @var array $page */
/** @var array $sections */
ob_start();
?>
<div class="panel">
    <div class="panel-head"><h2>Page Settings</h2></div>
    <form method="post" action="/admin/pages/<?= (int) $page['id'] ?>/update">
        <?= Csrf::field() ?>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Page Title</label><input class="form-control" name="title" value="<?= e($page['title']) ?>" required></div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select class="form-control" name="status">
                    <option value="published" <?= $page['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                    <option value="draft" <?= $page['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
        </div>
        <div class="form-group"><label class="form-label">SEO Title</label><input class="form-control" name="seo_title" value="<?= e($page['seo_title'] ?? '') ?>"></div>
        <div class="form-group"><label class="form-label">Meta Description</label><textarea class="form-control" name="seo_description"><?= e($page['seo_description'] ?? '') ?></textarea></div>
        <button class="btn btn-primary" type="submit">Save Page Settings</button>
    </form>
</div>

<div class="panel-head" style="margin-bottom:16px;">
    <h2 style="font-size:16px;">Sections</h2>
    <button class="btn btn-primary btn-sm" type="button" data-modal-open="addSectionModal">+ Add Section</button>
</div>

<div id="sectionsList">
    <?php foreach ($sections as $s): ?>
        <div class="panel" data-section-id="<?= (int) $s['id'] ?>" draggable="true" style="cursor:grab;display:flex;justify-content:space-between;align-items:center;gap:16px;">
            <div style="display:flex;align-items:center;gap:14px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--admin-muted);"><path d="M8 6h.01M8 12h.01M8 18h.01M16 6h.01M16 12h.01M16 18h.01"/></svg>
                <div>
                    <span class="badge badge-neutral"><?= e(AVAILABLE_SECTION_TYPES[$s['section_type']] ?? $s['section_type']) ?></span>
                    <strong style="margin-left:8px;"><?= e($s['heading'] ?: '(no heading)') ?></strong>
                </div>
            </div>
            <div style="display:flex;gap:8px;align-items:center;">
                <span class="badge <?= $s['is_active'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $s['is_active'] ? 'Visible' : 'Hidden' ?></span>
                <button class="icon-btn" type="button" data-modal-open="editSectionModal<?= (int) $s['id'] ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                </button>
                <form method="post" action="/admin/pages/<?= (int) $page['id'] ?>/sections/<?= (int) $s['id'] ?>/delete" data-confirm="Remove this section?">
                    <?= Csrf::field() ?>
                    <button class="icon-btn danger" type="submit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="modal-backdrop" id="editSectionModal<?= (int) $s['id'] ?>">
            <div class="modal-box">
                <div class="modal-head"><h3>Edit Section — <?= e(AVAILABLE_SECTION_TYPES[$s['section_type']] ?? $s['section_type']) ?></h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
                <form method="post" action="/admin/pages/<?= (int) $page['id'] ?>/sections/<?= (int) $s['id'] ?>/update">
                    <div class="modal-body">
                        <?= Csrf::field() ?>
                        <div class="form-group"><label class="form-label">Heading</label><input class="form-control" name="heading" value="<?= e($s['heading'] ?? '') ?>"></div>
                        <div class="form-group"><label class="form-label">Subheading</label><input class="form-control" name="subheading" value="<?= e($s['subheading'] ?? '') ?>"></div>
                        <div class="form-group"><label class="form-label">Content (used by Text/FAQ sections)</label><textarea class="form-control" name="content"><?= e($s['content'] ?? '') ?></textarea></div>
                        <label class="chip-check"><input type="checkbox" name="is_active" <?= $s['is_active'] ? 'checked' : '' ?>> Visible on page</label>
                    </div>
                    <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Section</button></div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (!$sections): ?><p style="color:var(--admin-muted);">No sections yet — add one to build this page.</p><?php endif; ?>
</div>

<div class="modal-backdrop" id="addSectionModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Add Section</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/pages/<?= (int) $page['id'] ?>/sections/store">
            <div class="modal-body">
                <?= Csrf::field() ?>
                <div class="form-group">
                    <label class="form-label">Section Type</label>
                    <select class="form-control" name="section_type">
                        <?php foreach (AVAILABLE_SECTION_TYPES as $val => $lbl): ?><option value="<?= $val ?>"><?= $lbl ?></option><?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add Section</button></div>
        </form>
    </div>
</div>

<script>
(function () {
    var list = document.getElementById('sectionsList');
    var csrf = document.getElementById('csrfToken').value;
    var dragEl = null;
    Array.prototype.forEach.call(list.querySelectorAll('[data-section-id]'), function (item) {
        item.addEventListener('dragstart', function () { dragEl = item; item.classList.add('dragging'); });
        item.addEventListener('dragend', function () {
            item.classList.remove('dragging');
            var ids = Array.prototype.map.call(list.querySelectorAll('[data-section-id]'), function (el) { return el.dataset.sectionId; });
            fetch('/admin/pages/<?= (int) $page['id'] ?>/sections/reorder', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ order: ids, _csrf: csrf })
            });
        });
        item.addEventListener('dragover', function (e) {
            e.preventDefault();
            var items = Array.prototype.slice.call(list.querySelectorAll('[data-section-id]:not(.dragging)'));
            var closest = { offset: Number.NEGATIVE_INFINITY, element: null };
            items.forEach(function (child) {
                var box = child.getBoundingClientRect();
                var offset = e.clientY - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) closest = { offset: offset, element: child };
            });
            if (!dragEl) return;
            if (closest.element == null) list.appendChild(dragEl); else list.insertBefore(dragEl, closest.element);
        });
    });
})();
</script>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Edit Page', 'active' => 'pages', 'content' => $content]);
