<?php
/** @var array $pagination */
$cur = $pagination['current_page'];
$last = $pagination['last_page'];
if ($last <= 1) return;
$window = 2;
?>
<nav class="pagination" aria-label="Pagination">
    <a href="?<?= query_string_with(['page' => max(1, $cur - 1)]) ?>" class="<?= $cur === 1 ? 'disabled' : '' ?>">&larr;</a>
    <?php for ($i = 1; $i <= $last; $i++): ?>
        <?php if ($i === 1 || $i === $last || abs($i - $cur) <= $window): ?>
            <a href="?<?= query_string_with(['page' => $i]) ?>" class="<?= $i === $cur ? 'active' : '' ?>"><?= $i ?></a>
        <?php elseif (abs($i - $cur) === $window + 1): ?>
            <span>&hellip;</span>
        <?php endif; ?>
    <?php endfor; ?>
    <a href="?<?= query_string_with(['page' => min($last, $cur + 1)]) ?>" class="<?= $cur === $last ? 'disabled' : '' ?>">&rarr;</a>
</nav>
