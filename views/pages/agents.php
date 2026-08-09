<?php
/** @var array $agents */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Agents</span></div>
    <div class="section-head"><div><span class="eyebrow">Our Team</span><h1 style="font-size:30px;">Meet Our Agents</h1></div></div>
    <div class="agent-grid">
        <?php foreach ($agents as $a): view('partials/agent-card', ['agent' => $a]); endforeach; ?>
    </div>
    <?php if (!$agents): ?><div class="empty-state"><h3>No agents to show yet</h3></div><?php endif; ?>
</div>
<?php view('layouts/site-footer'); ?>
