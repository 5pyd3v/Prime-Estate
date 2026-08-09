<?php
declare(strict_types=1);

function admin_blog_index(): void
{
    Auth::require();
    $page = max(1, (int) input('page', 1));
    $result = BlogPost::adminList($page, 15);
    $categories = BlogCategory::all('name');
    view('admin/blog/index', [
        'title' => 'Blog', 'active' => 'blog',
        'items' => $result['items'], 'pagination' => $result['pagination'], 'categories' => $categories,
    ]);
}

function admin_blog_categories_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $name = trim((string) input('name', ''));
    if ($name !== '') {
        BlogCategory::insert(['name' => $name, 'slug' => unique_slug(fn ($s) => (bool) BlogCategory::findBy('slug', $s), $name)]);
        flash('success', 'Category added.');
    }
    redirect('/admin/blog');
}

function admin_blog_categories_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    BlogCategory::delete($id);
    flash('success', 'Category deleted.');
    redirect('/admin/blog');
}

function blog_form_meta(): array
{
    return ['categories' => BlogCategory::all('name'), 'tags' => Tag::all('name')];
}

function admin_blog_create_show(): void
{
    Auth::require();
    view('admin/blog/create', array_merge(['title' => 'Add Blog Post', 'active' => 'blog', 'post' => null, 'selectedTags' => []], blog_form_meta()));
}

function blog_post_payload(): array
{
    $status = input('status') === 'published' ? 'published' : 'draft';
    return [
        'title' => trim((string) input('title', '')),
        'category_id' => (int) input('category_id') ?: null,
        'featured_image_id' => (int) input('featured_image_id') ?: null,
        'excerpt' => trim((string) input('excerpt', '')) ?: null,
        'content' => trim((string) input('content', '')) ?: null,
        'status' => $status,
        'seo_title' => trim((string) input('seo_title', '')) ?: null,
        'seo_description' => trim((string) input('seo_description', '')) ?: null,
        'published_at' => $status === 'published' ? date('Y-m-d H:i:s') : null,
    ];
}

function admin_blog_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = blog_post_payload();
    if ($data['title'] === '') {
        flash('error', 'Title is required.');
        redirect('/admin/blog/create');
    }
    $data['slug'] = unique_slug(fn ($slug) => (bool) BlogPost::findBy('slug', $slug), $data['title']);
    $data['author_id'] = Auth::id();
    $id = BlogPost::insert($data);

    $tagNames = array_filter(array_map('trim', explode(',', (string) input('tags', ''))));
    BlogPost::setTags($id, Tag::findOrCreateByNames($tagNames));

    flash('success', 'Blog post created.');
    redirect("/admin/blog/{$id}/edit");
}

function admin_blog_edit_show(int $id): void
{
    Auth::require();
    $post = BlogPost::find($id);
    if (!$post) {
        abort(404);
    }
    $selectedTags = array_column(BlogPost::tags($id), 'name');
    view('admin/blog/edit', array_merge(['title' => 'Edit Blog Post', 'active' => 'blog', 'post' => $post, 'selectedTags' => $selectedTags], blog_form_meta()));
}

function admin_blog_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    $post = BlogPost::find($id);
    if (!$post) {
        abort(404);
    }
    $data = blog_post_payload();
    if ($data['title'] === '') {
        flash('error', 'Title is required.');
        redirect("/admin/blog/{$id}/edit");
    }
    if ($post['status'] === 'published' && $data['status'] === 'published') {
        $data['published_at'] = $post['published_at'];
    }
    $data['slug'] = slug_for_update('blog_posts', $id, $data['title'], $post);
    BlogPost::update($id, $data);

    $tagNames = array_filter(array_map('trim', explode(',', (string) input('tags', ''))));
    BlogPost::setTags($id, Tag::findOrCreateByNames($tagNames));

    flash('success', 'Blog post updated.');
    redirect("/admin/blog/{$id}/edit");
}

function admin_blog_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    BlogPost::delete($id);
    flash('success', 'Blog post deleted.');
    redirect('/admin/blog');
}
