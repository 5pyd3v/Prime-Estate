<?php
/** @var array $sections */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
?>
<div style="padding-top:70px;">
<?php foreach ($sections as $section): ?>
    <?php view('partials/render-section', ['section' => $section]); ?>
<?php endforeach; ?>
</div>
<?php view('layouts/site-footer'); ?>
