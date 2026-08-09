<?php
declare(strict_types=1);

function admin_login_show(): void
{
    if (Auth::check()) {
        redirect('/admin/dashboard');
    }
    view('admin/login', ['title' => 'Admin Login']);
}

function admin_login_submit(): void
{
    Csrf::verifyRequest();

    $email = trim((string) input('email', ''));
    $password = (string) input('password', '');

    if ($email === '' || $password === '') {
        flash('error', 'Please enter both email and password.');
        redirect('/admin/login');
    }

    if (Auth::attempt($email, $password)) {
        redirect('/admin/dashboard');
    }

    flash('error', 'Invalid credentials, or too many attempts. Please try again shortly.');
    $_SESSION['_old'] = ['email' => $email];
    redirect('/admin/login');
}

function admin_logout(): void
{
    Auth::logout();
    redirect('/admin/login');
}

function admin_change_password_show(): void
{
    Auth::require();
    view('admin/change-password', ['title' => 'Change Password']);
}

function admin_change_password_submit(): void
{
    Auth::require();
    Csrf::verifyRequest();

    $current = (string) input('current_password', '');
    $new = (string) input('new_password', '');
    $confirm = (string) input('confirm_password', '');

    $user = Auth::user();

    if (!password_verify($current, $user['password_hash'])) {
        flash('error', 'Current password is incorrect.');
        redirect('/admin/change-password');
    }
    if (strlen($new) < 8) {
        flash('error', 'New password must be at least 8 characters.');
        redirect('/admin/change-password');
    }
    if ($new !== $confirm) {
        flash('error', 'New password and confirmation do not match.');
        redirect('/admin/change-password');
    }

    User::update((int) $user['id'], ['password_hash' => password_hash($new, PASSWORD_DEFAULT)]);
    flash('success', 'Password updated successfully.');
    redirect('/admin/change-password');
}
