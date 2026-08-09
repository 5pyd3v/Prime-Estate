<?php
/** @var array $items */
/** @var array $pagination */
/** @var array $categories */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Blog</span></div>
    <div class="section-head">
        <div><span class="eyebrow">Insights</span><h1 style="font-size:30px;">Blog & Market Insights</h1></div>
    </div>

    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:30px;">
        <a href="/blog" class="badge <?= empty($_GET['category']) ? 'badge-sale' : 'badge-neutral' ?>">All</a>
        <?php foreach ($categories as $c): ?>
            <a href="/blog?category=<?= e($c['slug']) ?>" class="badge <?= ($_GET['category'] ?? '') === $c['slug'] ? 'badge-sale' : 'badge-neutral' ?>"><?= e($c['name']) ?> (<?= (int) $c['post_count'] ?>)</a>
        <?php endforeach; ?>
    </div>

    <?php if ($items): ?>
        <div class="blog-grid">
            <?php foreach ($items as $post): view('partials/blog-card', ['post' => $post]); endforeach; ?>
        </div>
        <?php view('partials/pagination', ['pagination' => $pagination]); ?>
    <?php else: ?>
        <div class="empty-state"><h3>No posts found</h3></div>
    <?php endif; ?>
</div>
<?php view('layouts/site-footer'); ?>
