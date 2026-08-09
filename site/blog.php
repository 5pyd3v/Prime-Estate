<?php
declare(strict_types=1);

function site_blog_index(): void
{
    $page = max(1, (int) input('page', 1));
    $filters = ['category' => (string) input('category', ''), 'tag' => (string) input('tag', '')];
    $result = BlogPost::published($filters, $page, 9);

    view('pages/blog', [
        'title' => 'Blog & Market Insights',
        'description' => 'Real estate tips, market trends and area guides from the Prime Estates team.',
        'heroPage' => false,
        'items' => $result['items'],
        'pagination' => $result['pagination'],
        'categories' => BlogCategory::withCounts(),
    ]);
}

function site_blog_post(array $params): void
{
    $post = BlogPost::bySlug($params['slug']);
    if (!$post || $post['status'] !== 'published') {
        abort(404);
    }

    $tags = BlogPost::tags((int) $post['id']);
    $related = BlogPost::related((int) $post['id'], $post['category_id'] ?: null, 3);

    view('pages/blog-post', [
        'title' => $post['seo_title'] ?: $post['title'],
        'description' => $post['seo_description'] ?: $post['excerpt'] ?: '',
        'ogImage' => $post['featured_image_id'] ? media_url((Media::find((int) $post['featured_image_id'])['path'] ?? null)) : null,
        'heroPage' => false,
        'post' => $post,
        'tags' => $tags,
        'related' => $related,
    ]);
}
