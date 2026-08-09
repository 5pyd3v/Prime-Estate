<?php
/** @var array|null $agent */
$a = $agent ?? [];
$isEdit = $agent !== null;
function av(array $a, string $key, string $default = ''): string
{
    return e((string) ($a[$key] ?? $default));
}
ob_start();
?>
<form method="post" action="<?= $isEdit ? '/admin/agents/' . (int) $a['id'] . '/update' : '/admin/agents/store' ?>">
    <?= Csrf::field() ?>
    <div class="panel" style="max-width:640px;">
        <?= media_picker_field('photo_media_id', (int) ($a['photo_media_id'] ?? 0), 'image', 'Photo') ?>
        <div class="form-row" style="margin-top:16px;">
            <div class="form-group"><label class="form-label">Name *</label><input class="form-control" name="name" value="<?= av($a, 'name') ?>" required></div>
            <div class="form-group"><label class="form-label">Designation</label><input class="form-control" name="designation" value="<?= av($a, 'designation') ?>"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= av($a, 'phone') ?>"></div>
            <div class="form-group"><label class="form-label">WhatsApp</label><input class="form-control" name="whatsapp" value="<?= av($a, 'whatsapp') ?>"></div>
            <div class="form-group"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= av($a, 'email') ?>"></div>
        </div>
        <div class="form-group"><label class="form-label">Bio</label><textarea class="form-control" name="bio"><?= av($a, 'bio') ?></textarea></div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Facebook URL</label><input class="form-control" name="facebook_url" value="<?= av($a, 'facebook_url') ?>"></div>
            <div class="form-group"><label class="form-label">Instagram URL</label><input class="form-control" name="instagram_url" value="<?= av($a, 'instagram_url') ?>"></div>
            <div class="form-group"><label class="form-label">LinkedIn URL</label><input class="form-control" name="linkedin_url" value="<?= av($a, 'linkedin_url') ?>"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= av($a, 'sort_order', '0') ?>"></div>
            <div class="form-group" style="align-self:end;"><label class="chip-check"><input type="checkbox" name="is_active" <?= ($isEdit ? !empty($a['is_active']) : true) ? 'checked' : '' ?>> Active</label></div>
        </div>
    </div>
    <div style="display:flex;gap:10px;">
        <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Save Changes' : 'Add Agent' ?></button>
        <a class="btn btn-secondary" href="/admin/agents">Cancel</a>
    </div>
</form>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => $isEdit ? 'Edit Agent' : 'Add Agent', 'active' => 'agents', 'content' => $content]);
