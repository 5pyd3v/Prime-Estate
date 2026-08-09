<?php
/** @var array $settings */
function sv(array $settings, string $key, string $default = ''): string
{
    return e($settings[$key] ?? $default);
}
$s = $settings;
ob_start();

$tabs = [
    'general' => 'General',
    'branding' => 'Branding',
    'contact' => 'Contact',
    'social' => 'Social Media',
    'seo' => 'SEO',
    'homepage' => 'Homepage',
    'footer' => 'Footer',
    'whatsapp' => 'WhatsApp',
    'email' => 'Email',
    'maps' => 'Maps',
    'appearance' => 'Appearance',
];
$activeTab = $_GET['tab'] ?? 'general';
?>
<form method="post" action="/admin/settings/update">
    <?= Csrf::field() ?>
    <input type="hidden" name="tab" id="activeTabInput" value="<?= e($activeTab) ?>">

    <div class="tab-bar" data-tabs="settingsTabs">
        <?php foreach ($tabs as $key => $label): ?>
            <a href="#" class="tab-link <?= $activeTab === $key ? 'active' : '' ?>" data-tab="<?= $key ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </div>

    <div id="settingsTabs">
        <div class="panel" data-tab-panel="general" style="display:<?= $activeTab === 'general' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Site Name</label><input class="form-control" name="site_name" value="<?= sv($s, 'site_name') ?>"></div>
            <div class="form-group"><label class="form-label">Legal Company Name</label><input class="form-control" name="company_name" value="<?= sv($s, 'company_name') ?>"></div>
            <div class="form-group"><label class="form-label">Tagline</label><input class="form-control" name="tagline" value="<?= sv($s, 'tagline') ?>"></div>
        </div>

        <div class="panel" data-tab-panel="branding" style="display:<?= $activeTab === 'branding' ? 'block' : 'none' ?>;">
            <div class="form-row">
                <?= media_picker_field('logo_media_id', (int) ($s['logo_media_id'] ?? 0), 'image', 'Logo') ?>
                <?= media_picker_field('favicon_media_id', (int) ($s['favicon_media_id'] ?? 0), 'image', 'Favicon') ?>
            </div>
            <div class="form-row" style="margin-top:18px;">
                <div class="form-group"><label class="form-label">Primary Color</label><input class="form-control" type="color" name="primary_color" value="<?= sv($s, 'primary_color', '#16302B') ?>"></div>
                <div class="form-group"><label class="form-label">Secondary Color</label><input class="form-control" type="color" name="secondary_color" value="<?= sv($s, 'secondary_color', '#B08D57') ?>"></div>
                <div class="form-group"><label class="form-label">Accent Color</label><input class="form-control" type="color" name="accent_color" value="<?= sv($s, 'accent_color', '#E8873A') ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Background Color</label><input class="form-control" type="color" name="bg_color" value="<?= sv($s, 'bg_color', '#FAF9F6') ?>"></div>
                <div class="form-group"><label class="form-label">Text Color</label><input class="form-control" type="color" name="text_color" value="<?= sv($s, 'text_color', '#1A1A1A') ?>"></div>
            </div>
        </div>

        <div class="panel" data-tab-panel="contact" style="display:<?= $activeTab === 'contact' ? 'block' : 'none' ?>;">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= sv($s, 'phone') ?>"></div>
                <div class="form-group"><label class="form-label">WhatsApp Number</label><input class="form-control" name="whatsapp" value="<?= sv($s, 'whatsapp') ?>"></div>
            </div>
            <div class="form-group"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= sv($s, 'email') ?>"></div>
            <div class="form-group"><label class="form-label">Address</label><textarea class="form-control" name="address"><?= sv($s, 'address') ?></textarea></div>
            <div class="form-group"><label class="form-label">Working Hours</label><input class="form-control" name="working_hours" value="<?= sv($s, 'working_hours') ?>"></div>
            <div class="form-group"><label class="form-label">Google Maps URL</label><input class="form-control" name="google_maps_url" value="<?= sv($s, 'google_maps_url') ?>"></div>
        </div>

        <div class="panel" data-tab-panel="social" style="display:<?= $activeTab === 'social' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Facebook URL</label><input class="form-control" name="facebook_url" value="<?= sv($s, 'facebook_url') ?>"></div>
            <div class="form-group"><label class="form-label">Instagram URL</label><input class="form-control" name="instagram_url" value="<?= sv($s, 'instagram_url') ?>"></div>
            <div class="form-group"><label class="form-label">LinkedIn URL</label><input class="form-control" name="linkedin_url" value="<?= sv($s, 'linkedin_url') ?>"></div>
            <div class="form-group"><label class="form-label">YouTube URL</label><input class="form-control" name="youtube_url" value="<?= sv($s, 'youtube_url') ?>"></div>
            <div class="form-group"><label class="form-label">TikTok URL</label><input class="form-control" name="tiktok_url" value="<?= sv($s, 'tiktok_url') ?>"></div>
        </div>

        <div class="panel" data-tab-panel="seo" style="display:<?= $activeTab === 'seo' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Default SEO Title</label><input class="form-control" name="default_seo_title" value="<?= sv($s, 'default_seo_title') ?>"></div>
            <div class="form-group"><label class="form-label">Default Meta Description</label><textarea class="form-control" name="default_seo_description"><?= sv($s, 'default_seo_description') ?></textarea></div>
        </div>

        <div class="panel" data-tab-panel="homepage" style="display:<?= $activeTab === 'homepage' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Hero Heading</label><input class="form-control" name="hero_heading" value="<?= sv($s, 'hero_heading') ?>"></div>
            <div class="form-group"><label class="form-label">Hero Subheading</label><textarea class="form-control" name="hero_subheading"><?= sv($s, 'hero_subheading') ?></textarea></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Primary CTA Text</label><input class="form-control" name="hero_cta_text" value="<?= sv($s, 'hero_cta_text') ?>"></div>
                <div class="form-group"><label class="form-label">Primary CTA URL</label><input class="form-control" name="hero_cta_url" value="<?= sv($s, 'hero_cta_url') ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Secondary CTA Text</label><input class="form-control" name="hero_secondary_cta_text" value="<?= sv($s, 'hero_secondary_cta_text') ?>"></div>
                <div class="form-group"><label class="form-label">Secondary CTA URL</label><input class="form-control" name="hero_secondary_cta_url" value="<?= sv($s, 'hero_secondary_cta_url') ?>"></div>
            </div>
            <label class="form-label">Hero Slideshow Images</label>
            <div class="form-row">
                <?= media_picker_field('hero_image_1', (int) ($s['hero_image_1'] ?? 0), 'image') ?>
                <?= media_picker_field('hero_image_2', (int) ($s['hero_image_2'] ?? 0), 'image') ?>
                <?= media_picker_field('hero_image_3', (int) ($s['hero_image_3'] ?? 0), 'image') ?>
            </div>
            <div class="form-group" style="max-width:220px;margin-top:14px;"><label class="form-label">Overlay Opacity (0–1)</label><input class="form-control" name="hero_overlay_opacity" value="<?= sv($s, 'hero_overlay_opacity', '0.45') ?>"></div>
        </div>

        <div class="panel" data-tab-panel="footer" style="display:<?= $activeTab === 'footer' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Footer Description</label><textarea class="form-control" name="footer_description"><?= sv($s, 'footer_description') ?></textarea></div>
            <div class="form-group"><label class="form-label">Copyright Text</label><input class="form-control" name="footer_copyright" value="<?= sv($s, 'footer_copyright') ?>"><div class="form-hint">Use {year} to insert the current year automatically.</div></div>
        </div>

        <div class="panel" data-tab-panel="whatsapp" style="display:<?= $activeTab === 'whatsapp' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">WhatsApp Number</label><input class="form-control" name="whatsapp" value="<?= sv($s, 'whatsapp') ?>"><div class="form-hint">Include country code, e.g. +923001234567. Shared with the Contact tab.</div></div>
            <div class="form-group"><label class="form-label">Default Message</label><textarea class="form-control" name="whatsapp_default_message"><?= sv($s, 'whatsapp_default_message') ?></textarea></div>
        </div>

        <div class="panel" data-tab-panel="email" style="display:<?= $activeTab === 'email' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Notification Recipient Email</label><input class="form-control" type="email" name="notify_email" value="<?= sv($s, 'notify_email') ?>"><div class="form-hint">Contact form and inquiry alerts are sent here.</div></div>
            <div class="form-group"><label class="form-label">"From" Name</label><input class="form-control" name="notify_from_name" value="<?= sv($s, 'notify_from_name') ?>"></div>
            <div class="alert alert-info">SMTP server credentials are configured via the <code>.env</code> file for security and are not editable here.</div>
        </div>

        <div class="panel" data-tab-panel="maps" style="display:<?= $activeTab === 'maps' ? 'block' : 'none' ?>;">
            <div class="form-group"><label class="form-label">Google Maps URL</label><input class="form-control" name="google_maps_url" value="<?= sv($s, 'google_maps_url') ?>"><div class="form-hint">Used on the Contact page map embed and location links. Shared with the Contact tab.</div></div>
        </div>

        <div class="panel" data-tab-panel="appearance" style="display:<?= $activeTab === 'appearance' ? 'block' : 'none' ?>;">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Button Style</label>
                    <select class="form-control" name="button_style">
                        <?php foreach (['pill' => 'Pill', 'rounded' => 'Rounded', 'square' => 'Square'] as $val => $lbl): ?>
                            <option value="<?= $val ?>" <?= ($s['button_style'] ?? 'pill') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Border Radius (px)</label><input class="form-control" type="number" name="border_radius" value="<?= sv($s, 'border_radius', '14') ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Navbar Style</label>
                    <select class="form-control" name="nav_style">
                        <option value="floating-pill" <?= ($s['nav_style'] ?? '') === 'floating-pill' ? 'selected' : '' ?>>Floating Pill</option>
                        <option value="standard" <?= ($s['nav_style'] ?? '') === 'standard' ? 'selected' : '' ?>>Standard Bar</option>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Container Width (px)</label><input class="form-control" type="number" name="container_width" value="<?= sv($s, 'container_width', '1280') ?>"></div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Save Settings</button>
</form>

<script>
document.querySelectorAll('#settingsTabs').forEach(function(){});
document.querySelectorAll('.tab-link').forEach(function (link) {
    link.addEventListener('click', function () {
        document.getElementById('activeTabInput').value = link.dataset.tab;
        history.replaceState(null, '', '?tab=' + link.dataset.tab);
    });
});
</script>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Settings', 'active' => 'settings', 'content' => $content]);
