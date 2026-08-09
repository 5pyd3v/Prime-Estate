<?php
ob_start();
view('admin/projects/_form', ['project' => $project, 'cities' => $cities, 'images' => $images]);
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Edit Project', 'active' => 'projects', 'content' => $content]);
