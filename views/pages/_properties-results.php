<?php
/** @var array $items */
/** @var array $pagination */
?>
<div class="listing-count"><?= (int) $pagination['total'] ?> propert<?= $pagination['total'] === 1 ? 'y' : 'ies' ?> found</div>
<?php if ($items): ?>
    <div class="property-grid" style="margin-top:18px;">
        <?php foreach ($items as $property): view('partials/property-card', ['property' => $property]); endforeach; ?>
    </div>
    <?php view('partials/pagination', ['pagination' => $pagination]); ?>
<?php else: ?>
    <div class="empty-state">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
        <h3>No properties match your search</h3>
        <p>Try adjusting your filters or browse all available listings.</p>
    </div>
<?php endif; ?>
