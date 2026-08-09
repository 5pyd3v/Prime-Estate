<?php
declare(strict_types=1);

const SETTINGS_FIELD_GROUPS = [
    'general' => ['site_name', 'company_name', 'tagline'],
    'branding' => ['logo_media_id', 'favicon_media_id', 'primary_color', 'secondary_color', 'accent_color', 'bg_color', 'text_color'],
    'contact' => ['phone', 'whatsapp', 'email', 'address', 'working_hours', 'google_maps_url'],
    'social' => ['facebook_url', 'instagram_url', 'linkedin_url', 'youtube_url', 'tiktok_url'],
    'seo' => ['default_seo_title', 'default_seo_description'],
    'homepage' => ['hero_heading', 'hero_subheading', 'hero_cta_text', 'hero_cta_url', 'hero_secondary_cta_text', 'hero_secondary_cta_url', 'hero_image_1', 'hero_image_2', 'hero_image_3', 'hero_overlay_opacity'],
    'footer' => ['footer_description', 'footer_copyright'],
    'whatsapp' => ['whatsapp_default_message'],
    'email' => ['notify_email', 'notify_from_name'],
    'appearance' => ['button_style', 'border_radius', 'nav_style', 'container_width'],
];

function admin_settings_show(): void
{
    Auth::require();
    view('admin/settings/index', [
        'title' => 'Settings',
        'active' => 'settings',
        'settings' => Settings::all(),
    ]);
}

function admin_settings_update(): void
{
    Auth::require();
    Csrf::verifyRequest();

    $mediaFields = ['logo_media_id', 'favicon_media_id', 'hero_image_1', 'hero_image_2', 'hero_image_3'];

    foreach (SETTINGS_FIELD_GROUPS as $group => $fields) {
        foreach ($fields as $field) {
            if (!isset($_POST[$field])) {
                continue;
            }
            $value = (string) $_POST[$field];
            if (in_array($field, $mediaFields, true)) {
                $value = (string) (int) $value;
            }
            Settings::set($field, trim($value), $group);
        }
    }

    flash('success', 'Settings saved successfully.');
    redirect('/admin/settings' . (isset($_POST['tab']) ? '?tab=' . urlencode((string) $_POST['tab']) : ''));
}
