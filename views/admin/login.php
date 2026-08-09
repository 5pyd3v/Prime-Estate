<?php
$siteName = Settings::get('site_name', 'Real Estate CMS');
$logo = Settings::media('logo_media_id');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login · <?= e($siteName) ?></title>
<link rel="icon" href="<?= e($logo ?: asset('images/placeholder.svg')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap">
<link rel="stylesheet" href="<?= asset('css/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin-body">
<div class="auth-screen">
    <div class="auth-card">
        <div class="auth-logo">
            <?php if ($logo): ?><img src="<?= e($logo) ?>" alt=""><?php else: ?><strong><?= e($siteName) ?></strong><?php endif; ?>
        </div>
        <h1>Admin Sign In</h1>
        <p class="sub">Manage <?= e($siteName) ?> from your dashboard</p>

        <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>

        <form method="post" action="/admin/login" novalidate>
            <?= Csrf::field() ?>
            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <input class="form-control" type="email" id="email" name="email" value="<?= old('email') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Sign In</button>
        </form>
        <div class="auth-foot">Protected admin area &middot; Prime Estates CMS</div>
    </div>
</div>
</body>
</html>
