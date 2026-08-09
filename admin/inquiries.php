<?php
declare(strict_types=1);

function admin_inquiries_index(): void
{
    Auth::require();
    $page = max(1, (int) input('page', 1));
    $filters = ['status' => (string) input('status', ''), 'type' => (string) input('type', ''), 'q' => (string) input('q', '')];
    $result = Inquiry::adminList($filters, $page, 20);
    view('admin/inquiries/index', ['title' => 'Inquiries', 'active' => 'inquiries', 'items' => $result['items'], 'pagination' => $result['pagination'], 'filters' => $filters]);
}

function admin_inquiries_set_status(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    $status = input('status', 'new');
    if (in_array($status, ['new', 'contacted', 'closed'], true)) {
        Inquiry::update($id, ['status' => $status]);
    }
    redirect($_SERVER['HTTP_REFERER'] ?? '/admin/inquiries');
}

function admin_inquiries_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Inquiry::delete($id);
    flash('success', 'Inquiry deleted.');
    redirect('/admin/inquiries');
}
