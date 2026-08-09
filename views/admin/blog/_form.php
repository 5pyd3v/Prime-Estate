<?php
/** @var array|null $post */
/** @var array $categories */
/** @var array $tags */
/** @var array $selectedTags */
$p = $post ?? [];
$isEdit = $post !== null;
?>
<form method="post" action="<?= $isEdit ? '/admin/blog/' . (int) $p['id'] . '/update' : '/admin/blog/store' ?>">
    <?= Csrf::field() ?>
    <div class="two-col">
        <div>
            <div class="panel">
                <div class="form-group"><label class="form-label">Title *</label><input class="form-control" name="title" value="<?= e($p['title'] ?? '') ?>" required></div>
                <div class="form-group"><label class="form-label">Excerpt</label><textarea class="form-control" name="excerpt"><?= e($p['excerpt'] ?? '') ?></textarea></div>
                <div class="form-group"><label class="form-label">Content</label><textarea class="form-control" name="content" style="min-height:320px;"><?= e($p['content'] ?? '') ?></textarea></div>
            </div>
            <div class="panel">
                <div class="panel-head"><h2>SEO</h2></div>
                <div class="form-group"><label class="form-label">SEO Title</label><input class="form-control" name="seo_title" value="<?= e($p['seo_title'] ?? '') ?>"></div>
                <div class="form-group"><label class="form-label">Meta Description</label><textarea class="form-control" name="seo_description"><?= e($p['seo_description'] ?? '') ?></textarea></div>
            </div>
        </div>
        <div>
            <div class="panel">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="draft" <?= ($p['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= ($p['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-control" name="category_id">
                        <option value="">Uncategorized</option>
                        <?php foreach ($categories as $c): ?><option value="<?= (int) $c['id'] ?>" <?= (int) ($p['category_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Tags (comma separated)</label><input class="form-control" name="tags" value="<?= e(implode(', ', $selectedTags)) ?>"></div>
                <?= media_picker_field('featured_image_id', (int) ($p['featured_image_id'] ?? 0), 'image', 'Featured Image') ?>
            </div>
            <button class="btn btn-primary btn-block" type="submit"><?= $isEdit ? 'Save Changes' : 'Create Post' ?></button>
            <a class="btn btn-secondary btn-block" href="/admin/blog" style="margin-top:8px;">Cancel</a>
        </div>
    </div>
</form>
