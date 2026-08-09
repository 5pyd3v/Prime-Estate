<?php
declare(strict_types=1);

function admin_messages_index(): void
{
    Auth::require();
    $page = max(1, (int) input('page', 1));
    $filters = ['is_read' => (string) input('is_read', ''), 'q' => (string) input('q', '')];
    $result = ContactMessage::adminList($filters, $page, 20);
    view('admin/messages/index', ['title' => 'Contact Messages', 'active' => 'messages', 'items' => $result['items'], 'pagination' => $result['pagination'], 'filters' => $filters]);
}

function admin_messages_mark_read(int $id, bool $read): void
{
    Auth::require();
    Csrf::verifyRequest();
    ContactMessage::update($id, ['is_read' => $read ? 1 : 0]);
    redirect($_SERVER['HTTP_REFERER'] ?? '/admin/messages');
}

function admin_messages_mark_contacted(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    ContactMessage::update($id, ['is_contacted' => 1, 'is_read' => 1]);
    flash('success', 'Marked as contacted.');
    redirect($_SERVER['HTTP_REFERER'] ?? '/admin/messages');
}

function admin_messages_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    ContactMessage::delete($id);
    flash('success', 'Message deleted.');
    redirect('/admin/messages');
}
