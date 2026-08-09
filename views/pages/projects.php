<?php
/** @var array $items */
/** @var array $pagination */
/** @var array $cities */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Projects</span></div>
    <div class="section-head">
        <div><span class="eyebrow">Developments</span><h1 style="font-size:30px;">Real Estate Projects</h1></div>
        <form method="get" class="filter-bar">
            <select class="form-control" name="city" onchange="this.form.submit()">
                <option value="">All Cities</option>
                <?php foreach ($cities as $c): ?><option value="<?= e($c['slug']) ?>" <?= ($_GET['city'] ?? '') === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
            </select>
        </form>
    </div>

    <?php if ($items): ?>
        <div class="property-grid">
            <?php foreach ($items as $project): view('partials/project-card', ['project' => $project]); endforeach; ?>
        </div>
        <?php view('partials/pagination', ['pagination' => $pagination]); ?>
    <?php else: ?>
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="3" width="16" height="18" rx="1"/></svg>
            <h3>No projects found</h3>
            <p>Check back soon for new developments.</p>
        </div>
    <?php endif; ?>
</div>
<?php view('layouts/site-footer'); ?>
