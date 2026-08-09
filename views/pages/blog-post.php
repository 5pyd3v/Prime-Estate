<?php
/** @var array $post */
/** @var array $tags */
/** @var array $related */
$b = $post;
view('layouts/site-header', ['title' => $title, 'description' => $description, 'ogImage' => $ogImage ?? null, 'heroPage' => $heroPage]);
$img = $b['featured_image_id'] ? media_url((Media::find((int) $b['featured_image_id'])['path'] ?? null)) : null;
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;max-width:820px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <a href="/blog">Blog</a> <span>/</span> <span><?= e($b['title']) ?></span></div>

    <div class="blog-meta"><?= e($b['category_name'] ?? 'General') ?> &middot; <?= date('F j, Y', strtotime($b['published_at'] ?? $b['created_at'])) ?> &middot; By <?= e($b['author_name'] ?? 'Prime Estates') ?></div>
    <h1 style="font-size:32px;margin:10px 0 24px;"><?= e($b['title']) ?></h1>

    <?php if ($img): ?><img src="<?= e($img) ?>" alt="<?= e($b['title']) ?>" style="width:100%;border-radius:var(--radius);margin-bottom:30px;"><?php endif; ?>

    <div style="font-size:16px;line-height:1.85;color:#2c2c26;"><?= $b['content'] ?></div>

    <?php if ($tags): ?>
        <div style="margin-top:34px;">
            <?php foreach ($tags as $t): ?><a class="blog-tag" href="/blog?tag=<?= e($t['slug']) ?>"><?= e($t['name']) ?></a><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($related): ?>
    <section class="section-tight">
        <div class="section-head"><div><h2>Related Articles</h2></div></div>
        <div class="blog-grid">
            <?php foreach ($related as $rp): view('partials/blog-card', ['post' => $rp]); endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>
<?php view('layouts/site-footer'); ?>
