<?php
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
$phone = Settings::get('phone', '');
$whatsapp = Settings::get('whatsapp', '');
$email = Settings::get('email', '');
$address = Settings::get('address', '');
$hours = Settings::get('working_hours', '');
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Contact</span></div>
    <div class="section-head"><div><span class="eyebrow">Get In Touch</span><h1 style="font-size:30px;">Contact Us</h1><p>Have a question about buying, selling or renting? Our team is here to help.</p></div></div>

    <div class="two-col" style="align-items:start;">
        <div>
            <div class="panel" style="border:1px solid var(--color-border);border-radius:var(--radius);padding:26px;margin-bottom:24px;">
                <?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
                <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>
                <form data-ajax-form action="/contact" method="post">
                    <?= Csrf::field() ?>
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">Your Name *</label><input class="form-control" name="name" required></div>
                        <div class="form-group"><label class="form-label">Email Address *</label><input class="form-control" type="email" name="email" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">Phone Number</label><input class="form-control" name="phone"></div>
                        <div class="form-group"><label class="form-label">Subject</label><input class="form-control" name="subject"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Message *</label><textarea class="form-control" name="message" style="min-height:140px;" required></textarea></div>
                    <button class="btn btn-primary" type="submit">Send Message</button>
                </form>
            </div>
            <?php if ($address): ?>
                <div class="map-embed"><iframe src="https://www.google.com/maps?q=<?= urlencode($address) ?>&output=embed" loading="lazy"></iframe></div>
            <?php endif; ?>
        </div>
        <div>
            <div class="panel" style="border:1px solid var(--color-border);border-radius:var(--radius);padding:26px;">
                <h3 style="font-size:16px;margin-bottom:18px;">Contact Details</h3>
                <?php if ($phone): ?><div style="margin-bottom:16px;"><div style="font-size:12px;color:var(--color-muted);">Phone</div><a href="<?= e(tel_link($phone)) ?>" style="font-weight:600;"><?= e($phone) ?></a></div><?php endif; ?>
                <?php if ($whatsapp): ?><div style="margin-bottom:16px;"><div style="font-size:12px;color:var(--color-muted);">WhatsApp</div><a href="<?= e(whatsapp_link($whatsapp, Settings::get('whatsapp_default_message', ''))) ?>" target="_blank" rel="noopener" style="font-weight:600;"><?= e($whatsapp) ?></a></div><?php endif; ?>
                <?php if ($email): ?><div style="margin-bottom:16px;"><div style="font-size:12px;color:var(--color-muted);">Email</div><a href="mailto:<?= e($email) ?>" style="font-weight:600;"><?= e($email) ?></a></div><?php endif; ?>
                <?php if ($address): ?><div style="margin-bottom:16px;"><div style="font-size:12px;color:var(--color-muted);">Office Address</div><div style="font-weight:600;"><?= e($address) ?></div></div><?php endif; ?>
                <?php if ($hours): ?><div><div style="font-size:12px;color:var(--color-muted);">Working Hours</div><div style="font-weight:600;"><?= e($hours) ?></div></div><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php view('layouts/site-footer'); ?>
