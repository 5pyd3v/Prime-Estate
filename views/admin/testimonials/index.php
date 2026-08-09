<?php
/** @var array $items */
ob_start();
function testimonial_fields(array $t = []): void { ?>
    <div class="form-group"><label class="form-label">Client Name</label><input class="form-control" name="client_name" value="<?= e($t['client_name'] ?? '') ?>" required></div>
    <?= media_picker_field('photo_media_id', (int) ($t['photo_media_id'] ?? 0), 'image', 'Photo') ?>
    <div class="form-group" style="margin-top:14px;"><label class="form-label">Designation</label><input class="form-control" name="designation" value="<?= e($t['designation'] ?? '') ?>" placeholder="Homeowner, Islamabad"></div>
    <div class="form-group"><label class="form-label">Testimonial</label><textarea class="form-control" name="content" required><?= e($t['content'] ?? '') ?></textarea></div>
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Rating</label>
            <select class="form-control" name="rating">
                <?php for ($i = 5; $i >= 1; $i--): ?><option value="<?= $i ?>" <?= (int) ($t['rating'] ?? 5) === $i ? 'selected' : '' ?>><?= $i ?> Stars</option><?php endfor; ?>
            </select>
        </div>
        <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= (int) ($t['sort_order'] ?? 0) ?>"></div>
    </div>
    <div style="display:flex;gap:20px;">
        <label class="chip-check"><input type="checkbox" name="is_featured" <?= !empty($t['is_featured']) ? 'checked' : '' ?>> Featured</label>
        <label class="chip-check"><input type="checkbox" name="is_published" <?= ($t ? !empty($t['is_published']) : true) ? 'checked' : '' ?>> Published</label>
    </div>
<?php }
?>
<div class="toolbar">
    <div></div>
    <button class="btn btn-primary" type="button" data-modal-open="addTestimonialModal">+ Add Testimonial</button>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th></th><th>Client</th><th>Rating</th><th>Featured</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $t): ?>
            <tr>
                <td><img class="row-thumb" style="border-radius:50%;" src="<?= e($t['photo_media_id'] ? media_url((Media::find((int) $t['photo_media_id'])['path'] ?? null)) : asset('images/placeholder.svg')) ?>" alt=""></td>
                <td><?= e($t['client_name']) ?><div style="font-size:11.5px;color:var(--admin-muted);"><?= e($t['designation'] ?? '') ?></div></td>
                <td><?= str_repeat('★', (int) $t['rating']) ?></td>
                <td><?= $t['is_featured'] ? '✓' : '' ?></td>
                <td><span class="badge <?= $t['is_published'] ? 'badge-sale' : 'badge-neutral' ?>"><?= $t['is_published'] ? 'Published' : 'Draft' ?></span></td>
                <td class="row-actions">
                    <button class="icon-btn" type="button" data-modal-open="editTestimonialModal<?= (int) $t['id'] ?>" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                    </button>
                    <form method="post" action="/admin/testimonials/<?= (int) $t['id'] ?>/delete" data-confirm="Delete this testimonial?" style="display:inline;">
                        <?= Csrf::field() ?>
                        <button class="icon-btn danger" type="submit" title="Delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="6">No testimonials yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="addTestimonialModal">
    <div class="modal-box">
        <div class="modal-head"><h3>Add Testimonial</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/testimonials/store">
            <div class="modal-body"><?= Csrf::field() ?><?php testimonial_fields(); ?></div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Add Testimonial</button></div>
        </form>
    </div>
</div>

<?php foreach ($items as $t): ?>
<div class="modal-backdrop" id="editTestimonialModal<?= (int) $t['id'] ?>">
    <div class="modal-box">
        <div class="modal-head"><h3>Edit Testimonial</h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
        <form method="post" action="/admin/testimonials/<?= (int) $t['id'] ?>/update">
            <div class="modal-body"><?= Csrf::field() ?><?php testimonial_fields($t); ?></div>
            <div class="modal-foot"><button type="button" class="btn btn-secondary" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Save Changes</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Testimonials', 'active' => 'testimonials', 'content' => $content]);
