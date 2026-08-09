<?php
ob_start();
view('admin/blog/_form', ['post' => null, 'categories' => $categories, 'tags' => $tags, 'selectedTags' => []]);
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Add Blog Post', 'active' => 'blog', 'content' => $content]);
