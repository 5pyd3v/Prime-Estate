<?php
/** @var array $items */
/** @var array $pagination */
/** @var array $filters */
/** @var array $cities */
/** @var array $types */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
?>
<div class="container" style="padding-top:130px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Properties</span></div>

    <div class="listing-toolbar">
        <h1 style="font-size:26px;margin:0;">All Properties</h1>
        <button class="btn btn-secondary mobile-filter-btn" id="mobileFilterBtn" type="button">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
            Filters
        </button>
    </div>

    <div class="listing-layout">
        <div class="filter-overlay" id="filterOverlay"></div>
        <aside class="filter-sidebar" id="filterSidebar">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <h3>Filter Properties</h3>
                <button type="button" id="filterCloseBtn" class="mobile-filter-btn" style="background:none;border:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="filterForm" action="/properties" method="get">
                <div class="filter-group">
                    <label class="form-label">Purpose</label>
                    <select class="form-control" name="purpose">
                        <option value="">Buy or Rent</option>
                        <option value="sale" <?= $filters['purpose'] === 'sale' ? 'selected' : '' ?>>Buy</option>
                        <option value="rent" <?= $filters['purpose'] === 'rent' ? 'selected' : '' ?>>Rent</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="form-label">City</label>
                    <select class="form-control" name="city">
                        <option value="">Any City</option>
                        <?php foreach ($cities as $c): ?><option value="<?= e($c['slug']) ?>" <?= $filters['city'] === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="form-label">Property Type</label>
                    <select class="form-control" name="type">
                        <option value="">Any Type</option>
                        <?php foreach ($types as $t): ?><option value="<?= e($t['slug']) ?>" <?= $filters['type'] === $t['slug'] ? 'selected' : '' ?>><?= e($t['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="form-label">Price Range (PKR)</label>
                    <div style="display:flex;gap:8px;">
                        <input class="form-control" type="number" name="min_price" placeholder="Min" value="<?= e($filters['min_price']) ?>">
                        <input class="form-control" type="number" name="max_price" placeholder="Max" value="<?= e($filters['max_price']) ?>">
                    </div>
                </div>
                <div class="filter-group">
                    <label class="form-label">Bedrooms</label>
                    <select class="form-control" name="bedrooms">
                        <option value="">Any</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?><option value="<?= $i ?>" <?= $filters['bedrooms'] === (string) $i ? 'selected' : '' ?>><?= $i ?>+</option><?php endfor; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="form-label">Bathrooms</label>
                    <select class="form-control" name="bathrooms">
                        <option value="">Any</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?><option value="<?= $i ?>" <?= $filters['bathrooms'] === (string) $i ? 'selected' : '' ?>><?= $i ?>+</option><?php endfor; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="form-label">Furnished Status</label>
                    <select class="form-control" name="furnished">
                        <option value="">Any</option>
                        <option value="furnished" <?= $filters['furnished'] === 'furnished' ? 'selected' : '' ?>>Furnished</option>
                        <option value="semi_furnished" <?= $filters['furnished'] === 'semi_furnished' ? 'selected' : '' ?>>Semi-Furnished</option>
                        <option value="unfurnished" <?= $filters['furnished'] === 'unfurnished' ? 'selected' : '' ?>>Unfurnished</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="form-label">Sort By</label>
                    <select class="form-control" name="sort">
                        <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest First</option>
                        <option value="price_asc" <?= $filters['sort'] === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                    </select>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Apply Filters</button>
            </form>
        </aside>

        <div id="resultsContainer">
            <?php view('pages/_properties-results', ['items' => $items, 'pagination' => $pagination]); ?>
        </div>
    </div>
</div>

<script src="<?= asset('js/filters.js') ?>"></script>
<?php view('layouts/site-footer'); ?>
