<?php
/** @var string $purpose */
$purpose = $purpose ?? 'sale';
$cities = City::active();
$types = PropertyType::active();
?>
<div class="search-tabs">
    <a href="#" class="search-tab <?= $purpose === 'sale' ? 'active' : '' ?>" data-purpose-tab="sale">Buy</a>
    <a href="#" class="search-tab <?= $purpose === 'rent' ? 'active' : '' ?>" data-purpose-tab="rent">Rent</a>
</div>
<form class="search-panel" action="/properties" method="get">
    <input type="hidden" name="purpose" id="heroPurposeInput" value="<?= e($purpose) ?>">
    <div class="form-group">
        <label class="form-label">City</label>
        <select class="form-control" name="city">
            <option value="">Any City</option>
            <?php foreach ($cities as $c): ?><option value="<?= e($c['slug']) ?>"><?= e($c['name']) ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Property Type</label>
        <select class="form-control" name="type">
            <option value="">Any Type</option>
            <?php foreach ($types as $t): ?><option value="<?= e($t['slug']) ?>"><?= e($t['name']) ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Min Price (PKR)</label>
        <input class="form-control" type="number" name="min_price" placeholder="Any">
    </div>
    <div class="form-group">
        <label class="form-label">Max Price (PKR)</label>
        <input class="form-control" type="number" name="max_price" placeholder="Any">
    </div>
    <div class="form-group">
        <label class="form-label">Bedrooms</label>
        <select class="form-control" name="bedrooms">
            <option value="">Any</option>
            <?php for ($i = 1; $i <= 5; $i++): ?><option value="<?= $i ?>"><?= $i ?>+</option><?php endfor; ?>
        </select>
    </div>
    <button class="btn btn-primary" type="submit" style="height:44px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
        Search
    </button>
</form>
<script>
document.querySelectorAll('[data-purpose-tab]').forEach(function (tab) {
    tab.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelectorAll('[data-purpose-tab]').forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        document.getElementById('heroPurposeInput').value = tab.dataset.purposeTab;
    });
});
</script>
