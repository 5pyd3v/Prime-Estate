<?php
/** @var array $agent */
$a = $agent;
$photo = $a['photo_media_id'] ? media_url((Media::find((int) $a['photo_media_id'])['path'] ?? null)) : asset('images/placeholder.svg');
?>
<div class="agent-card">
    <img src="<?= e($photo) ?>" alt="<?= e($a['name']) ?>" loading="lazy">
    <h3><a href="/agent/<?= e($a['slug']) ?>" style="color:inherit;"><?= e($a['name']) ?></a></h3>
    <div class="role"><?= e($a['designation'] ?? '') ?></div>
    <div class="agent-actions">
        <?php if (!empty($a['phone'])): ?><a class="btn btn-secondary btn-sm" href="<?= e(tel_link($a['phone'])) ?>">Call</a><?php endif; ?>
        <?php if (!empty($a['whatsapp'])): ?><a class="btn btn-primary btn-sm" href="<?= e(whatsapp_link($a['whatsapp'], 'Hello ' . $a['name'] . ', I would like to know more about your listings.')) ?>" target="_blank" rel="noopener">WhatsApp</a><?php endif; ?>
    </div>
</div>
