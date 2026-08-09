<?php
ob_start();
view('admin/projects/_form', ['project' => null, 'cities' => $cities, 'images' => []]);
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Add Project', 'active' => 'projects', 'content' => $content]);
