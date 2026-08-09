<?php
declare(strict_types=1);

function site_submit_inquiry(): void
{
    $isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== '';

    if (!Csrf::verify($_POST['_csrf'] ?? null)) {
        respond_inquiry($isAjax, false, 'Your session expired. Please refresh the page and try again.');
        return;
    }

    $name = trim((string) input('name', ''));
    $phone = trim((string) input('phone', ''));
    $email = trim((string) input('email', ''));
    $message = trim((string) input('message', ''));
    $type = (string) input('inquiry_type', 'general');
    $propertyId = (int) input('property_id', 0) ?: null;
    $projectId = (int) input('project_id', 0) ?: null;
    $agentId = (int) input('agent_id', 0) ?: null;

    if ($name === '' || ($phone === '' && $email === '')) {
        respond_inquiry($isAjax, false, 'Please provide your name and a phone number or email.');
        return;
    }

    if (!in_array($type, ['details', 'visit', 'whatsapp', 'call', 'general'], true)) {
        $type = 'general';
    }

    Inquiry::insert([
        'property_id' => $propertyId,
        'project_id' => $projectId,
        'agent_id' => $agentId,
        'name' => $name,
        'phone' => $phone ?: null,
        'email' => $email ?: null,
        'message' => $message ?: null,
        'inquiry_type' => $type,
        'status' => 'new',
    ]);

    $notifyEmail = (string) Settings::get('notify_email', '');
    if ($notifyEmail !== '') {
        $subject = 'New Property Inquiry — ' . Settings::get('site_name', '');
        $body = '<p><strong>Name:</strong> ' . e($name) . '</p>'
            . '<p><strong>Phone:</strong> ' . e($phone) . '</p>'
            . '<p><strong>Email:</strong> ' . e($email) . '</p>'
            . '<p><strong>Type:</strong> ' . e($type) . '</p>'
            . '<p><strong>Message:</strong> ' . nl2br(e($message)) . '</p>';
        Mailer::send($notifyEmail, $subject, $body);
    }

    respond_inquiry($isAjax, true, "Thanks! We've received your inquiry and will be in touch shortly.");
}

function respond_inquiry(bool $isAjax, bool $ok, string $message): void
{
    if ($isAjax) {
        json_response(['ok' => $ok, 'message' => $message]);
    }
    flash($ok ? 'success' : 'error', $message);
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
}
