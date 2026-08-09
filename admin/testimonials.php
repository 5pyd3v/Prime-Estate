<?php
declare(strict_types=1);

function admin_testimonials_index(): void
{
    Auth::require();
    $items = DB::connection()->query('SELECT * FROM testimonials ORDER BY sort_order, id DESC')->fetchAll();
    view('admin/testimonials/index', ['title' => 'Testimonials', 'active' => 'testimonials', 'items' => $items]);
}

function testimonial_payload(): array
{
    return [
        'client_name' => trim((string) input('client_name', '')),
        'photo_media_id' => (int) input('photo_media_id') ?: null,
        'designation' => trim((string) input('designation', '')) ?: null,
        'content' => trim((string) input('content', '')),
        'rating' => max(1, min(5, (int) input('rating', 5))),
        'is_featured' => input('is_featured') ? 1 : 0,
        'is_published' => input('is_published') ? 1 : 0,
        'sort_order' => (int) input('sort_order', 0),
    ];
}

function admin_testimonials_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = testimonial_payload();
    if ($data['client_name'] === '' || $data['content'] === '') {
        flash('error', 'Client name and testimonial content are required.');
        redirect('/admin/testimonials');
    }
    Testimonial::insert($data);
    flash('success', 'Testimonial added.');
    redirect('/admin/testimonials');
}

function admin_testimonials_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Testimonial::update($id, testimonial_payload());
    flash('success', 'Testimonial updated.');
    redirect('/admin/testimonials');
}

function admin_testimonials_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Testimonial::delete($id);
    flash('success', 'Testimonial deleted.');
    redirect('/admin/testimonials');
}
