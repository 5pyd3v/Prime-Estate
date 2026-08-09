<?php
/** @var array|null $project */
/** @var array $cities */
/** @var array $images */
$p = $project ?? [];
$isEdit = $project !== null;
function prv(array $p, string $key, string $default = ''): string
{
    return e((string) ($p[$key] ?? $default));
}
?>
<form method="post" action="<?= $isEdit ? '/admin/projects/' . (int) $p['id'] . '/update' : '/admin/projects/store' ?>" enctype="multipart/form-data">
    <?= Csrf::field() ?>
    <div class="tab-bar" data-tabs="projectTabs">
        <a href="#" class="tab-link active" data-tab="basic">Basic</a>
        <a href="#" class="tab-link" data-tab="details">Details</a>
        <a href="#" class="tab-link" data-tab="media">Media<?= $isEdit ? ' (' . count($images) . ')' : '' ?></a>
        <a href="#" class="tab-link" data-tab="seo">SEO</a>
    </div>
    <div id="projectTabs">
        <div class="panel" data-tab-panel="basic">
            <div class="form-group"><label class="form-label">Project Name *</label><input class="form-control" name="name" value="<?= prv($p, 'name') ?>" required></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Developer</label><input class="form-control" name="developer" value="<?= prv($p, 'developer') ?>"></div>
                <div class="form-group">
                    <label class="form-label">City</label>
                    <select class="form-control" name="city_id">
                        <option value="">Select city</option>
                        <?php foreach ($cities as $c): ?><option value="<?= (int) $c['id'] ?>" <?= (int) ($p['city_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Location</label><input class="form-control" name="location" value="<?= prv($p, 'location') ?>"></div>
            <div class="form-group"><label class="form-label">Description</label><textarea class="form-control" name="description" style="min-height:140px;"><?= prv($p, 'description') ?></textarea></div>
            <div style="display:flex;gap:24px;">
                <label class="chip-check"><input type="checkbox" name="is_featured" <?= !empty($p['is_featured']) ? 'checked' : '' ?>> Featured</label>
                <label class="chip-check"><input type="checkbox" name="is_published" <?= ($isEdit ? !empty($p['is_published']) : true) ? 'checked' : '' ?>> Published</label>
            </div>
        </div>
        <div class="panel" data-tab-panel="details" style="display:none;">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Starting Price</label><input class="form-control" type="number" step="0.01" name="starting_price" value="<?= prv($p, 'starting_price') ?>"></div>
                <div class="form-group"><label class="form-label">Price Label</label><input class="form-control" name="price_label" value="<?= prv($p, 'price_label', 'Starting from') ?>"></div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <?php foreach (['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'] as $val => $lbl): ?>
                            <option value="<?= $val ?>" <?= ($p['status'] ?? 'upcoming') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Completion Date</label><input class="form-control" type="date" name="completion_date" value="<?= prv($p, 'completion_date') ?>"></div>
            <div class="form-group"><label class="form-label">Amenities (JSON array or comma list)</label><textarea class="form-control" name="amenities"><?= prv($p, 'amenities') ?></textarea></div>
            <div class="form-group"><label class="form-label">Payment Plan</label><textarea class="form-control" name="payment_plan"><?= prv($p, 'payment_plan') ?></textarea></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Video URL</label><input class="form-control" name="video_url" value="<?= prv($p, 'video_url') ?>"></div>
                <div class="form-group"><label class="form-label">Map URL</label><input class="form-control" name="map_url" value="<?= prv($p, 'map_url') ?>"></div>
            </div>
            <?= media_picker_field('brochure_media_id', (int) ($p['brochure_media_id'] ?? 0), 'document', 'Brochure (PDF)') ?>
        </div>
        <div class="panel" data-tab-panel="media" style="display:none;">
            <?= media_picker_field('logo_media_id', (int) ($p['logo_media_id'] ?? 0), 'image', 'Project Logo') ?>
            <?php if ($isEdit): ?>
                <label class="form-label" style="margin-top:18px;display:block;">Gallery</label>
                <div class="image-reorder-grid" id="imageReorderGrid" data-entity="projects" data-project-id="<?= (int) $p['id'] ?>">
                    <?php foreach ($images as $img): ?>
                        <div class="image-reorder-item" draggable="true" data-image-id="<?= (int) $img['id'] ?>">
                            <img src="<?= e(media_url($img['path'])) ?>" alt="">
                            <?php if ($img['is_primary']): ?><span class="primary-tag">Primary</span><?php endif; ?>
                            <div class="img-actions">
                                <button type="button" class="set-primary-btn" title="Set as primary">★</button>
                                <button type="button" class="delete-image-btn" title="Delete">✕</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="form-hint" style="margin:10px 0 18px;">Drag to reorder. Click ★ to set primary image.</p>
            <?php endif; ?>
            <label class="form-label">Upload <?= $isEdit ? 'More ' : '' ?>Images</label>
            <input type="file" class="form-control" name="images[]" multiple accept="image/jpeg,image/png,image/webp">
        </div>
        <div class="panel" data-tab-panel="seo" style="display:none;">
            <div class="form-group"><label class="form-label">SEO Title</label><input class="form-control" name="seo_title" value="<?= prv($p, 'seo_title') ?>"></div>
            <div class="form-group"><label class="form-label">Meta Description</label><textarea class="form-control" name="seo_description"><?= prv($p, 'seo_description') ?></textarea></div>
        </div>
    </div>
    <div style="display:flex;gap:10px;">
        <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Save Changes' : 'Create Project' ?></button>
        <a class="btn btn-secondary" href="/admin/projects">Cancel</a>
    </div>
</form>
<script src="<?= asset('js/gallery-reorder.js') ?>"></script>
