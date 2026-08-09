<?php
/** @var array $post */
$b = $post;
$img = $b['featured_image_id'] ? media_url((Media::find((int) $b['featured_image_id'])['path'] ?? null)) : asset('images/placeholder.svg');
?>
<article class="blog-card">
    <a href="/blog/<?= e($b['slug']) ?>" class="blog-card-media"><img src="<?= e($img) ?>" alt="<?= e($b['title']) ?>" loading="lazy"></a>
    <div class="blog-card-body">
        <div class="blog-meta"><?= e($b['category_name'] ?? 'General') ?> &middot; <?= date('M j, Y', strtotime($b['published_at'] ?? $b['created_at'])) ?></div>
        <h3><a href="/blog/<?= e($b['slug']) ?>" style="color:inherit;"><?= e($b['title']) ?></a></h3>
        <p><?= e(truncate($b['excerpt'] ?: $b['content'], 110)) ?></p>
    </div>
</article>
