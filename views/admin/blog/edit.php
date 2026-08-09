<?php
ob_start();
view('admin/blog/_form', ['post' => $post, 'categories' => $categories, 'tags' => $tags, 'selectedTags' => $selectedTags]);
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Edit Blog Post', 'active' => 'blog', 'content' => $content]);
