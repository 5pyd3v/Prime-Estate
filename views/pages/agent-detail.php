<?php
/** @var array $agent */
/** @var array $properties */
$a = $agent;
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
$photo = $a['photo_media_id'] ? media_url((Media::find((int) $a['photo_media_id'])['path'] ?? null)) : asset('images/placeholder.svg');
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <a href="/agents">Agents</a> <span>/</span> <span><?= e($a['name']) ?></span></div>

    <div class="detail-layout" style="grid-template-columns:320px 1fr;">
        <aside class="contact-panel" style="text-align:center;">
            <img src="<?= e($photo) ?>" alt="<?= e($a['name']) ?>" style="width:120px;height:120px;border-radius:50%;object-fit:cover;margin:0 auto 16px;">
            <h1 style="font-size:22px;margin-bottom:4px;"><?= e($a['name']) ?></h1>
            <div style="color:var(--color-muted);font-size:14px;margin-bottom:18px;"><?= e($a['designation'] ?? '') ?></div>
            <div class="cta-row">
                <?php if ($a['phone']): ?><a class="btn btn-secondary" href="<?= e(tel_link($a['phone'])) ?>">Call</a><?php endif; ?>
                <?php if ($a['whatsapp']): ?><a class="btn btn-primary" href="<?= e(whatsapp_link($a['whatsapp'], 'Hello ' . $a['name'] . ', I found your profile on the website.')) ?>" target="_blank" rel="noopener">WhatsApp</a><?php endif; ?>
            </div>
            <?php if ($a['email']): ?><div style="margin-top:14px;font-size:13.5px;"><a href="mailto:<?= e($a['email']) ?>"><?= e($a['email']) ?></a></div><?php endif; ?>
            <div class="agent-social">
                <?php foreach (['facebook_url' => 'f', 'instagram_url' => 'ig', 'linkedin_url' => 'in'] as $key => $abbr): if (!empty($a[$key])): ?>
                    <a href="<?= e($a[$key]) ?>" target="_blank" rel="noopener"><?= $abbr ?></a>
                <?php endif; endforeach; ?>
            </div>
        </aside>
        <div>
            <?php if ($a['bio']): ?><p style="font-size:15.5px;line-height:1.75;color:#3a3a34;margin-bottom:36px;"><?= nl2br(e($a['bio'])) ?></p><?php endif; ?>
            <h2 style="font-size:19px;">Listings by <?= e($a['name']) ?></h2>
            <div class="property-grid">
                <?php foreach ($properties as $p): view('partials/property-card', ['property' => $p]); endforeach; ?>
            </div>
            <?php if (!$properties): ?><p style="color:var(--color-muted);">No active listings right now.</p><?php endif; ?>
        </div>
    </div>
</div>
<?php view('layouts/site-footer'); ?>
