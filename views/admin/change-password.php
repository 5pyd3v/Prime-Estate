<?php
ob_start();
?>
<div class="panel" style="max-width:480px;">
    <div class="panel-head"><h2>Change Password</h2></div>
    <form method="post" action="/admin/change-password">
        <?= Csrf::field() ?>
        <div class="form-group">
            <label class="form-label" for="current_password">Current Password</label>
            <input class="form-control" type="password" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="new_password">New Password</label>
            <input class="form-control" type="password" id="new_password" name="new_password" minlength="8" required>
            <div class="form-hint">At least 8 characters.</div>
        </div>
        <div class="form-group">
            <label class="form-label" for="confirm_password">Confirm New Password</label>
            <input class="form-control" type="password" id="confirm_password" name="confirm_password" minlength="8" required>
        </div>
        <button class="btn btn-primary" type="submit">Update Password</button>
    </form>
</div>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Change Password', 'active' => '', 'content' => $content]);
