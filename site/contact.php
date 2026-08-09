<?php
declare(strict_types=1);

function site_contact(): void
{
    view('pages/contact', [
        'title' => 'Contact Us',
        'description' => 'Get in touch with Prime Estates — call, WhatsApp or send us a message.',
        'heroPage' => false,
    ]);
}

function site_submit_contact_message(): void
{
    $isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== '';

    if (!Csrf::verify($_POST['_csrf'] ?? null)) {
        respond_inquiry($isAjax, false, 'Your session expired. Please refresh the page and try again.');
        return;
    }

    $name = trim((string) input('name', ''));
    $email = trim((string) input('email', ''));
    $phone = trim((string) input('phone', ''));
    $subject = trim((string) input('subject', ''));
    $message = trim((string) input('message', ''));

    if ($name === '' || $email === '' || $message === '') {
        respond_inquiry($isAjax, false, 'Please fill in your name, email and message.');
        return;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond_inquiry($isAjax, false, 'Please enter a valid email address.');
        return;
    }

    ContactMessage::insert([
        'name' => $name,
        'email' => $email,
        'phone' => $phone ?: null,
        'subject' => $subject ?: null,
        'message' => $message,
    ]);

    $notifyEmail = (string) Settings::get('notify_email', '');
    if ($notifyEmail !== '') {
        $body = '<p><strong>Name:</strong> ' . e($name) . '</p>'
            . '<p><strong>Email:</strong> ' . e($email) . '</p>'
            . '<p><strong>Phone:</strong> ' . e($phone) . '</p>'
            . '<p><strong>Subject:</strong> ' . e($subject) . '</p>'
            . '<p><strong>Message:</strong> ' . nl2br(e($message)) . '</p>';
        Mailer::send($notifyEmail, 'New Contact Message — ' . Settings::get('site_name', ''), $body);
    }

    respond_inquiry($isAjax, true, "Thanks for reaching out! We'll get back to you shortly.");
}
