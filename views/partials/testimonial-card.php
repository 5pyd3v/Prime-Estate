<?php
/** @var array $testimonial */
$t = $testimonial;
$photo = $t['photo_media_id'] ? media_url((Media::find((int) $t['photo_media_id'])['path'] ?? null)) : asset('images/placeholder.svg');
?>
<div class="testimonial-card">
    <div class="testimonial-stars"><?= str_repeat('★', (int) $t['rating']) . str_repeat('☆', 5 - (int) $t['rating']) ?></div>
    <p class="testimonial-content">&ldquo;<?= e($t['content']) ?>&rdquo;</p>
    <div class="testimonial-person">
        <img src="<?= e($photo) ?>" alt="<?= e($t['client_name']) ?>" loading="lazy">
        <div>
            <div class="name"><?= e($t['client_name']) ?></div>
            <?php if (!empty($t['designation'])): ?><div class="role"><?= e($t['designation']) ?></div><?php endif; ?>
        </div>
    </div>
</div>
