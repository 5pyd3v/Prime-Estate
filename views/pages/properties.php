<?php
/** @var array $items */
/** @var array $pagination */
/** @var array $filters */
/** @var array $cities */
/** @var array $types */
view('layouts/site-header', ['title' => $title, 'description' => $description, 'heroPage' => $heroPage]);
?>
<div class="container" style="padding-top:126px;padding-bottom:80px;">
    <div class="breadcrumb"><a href="/">Home</a> <span>/</span> <span>Properties</span></div>

    <div class="page-heading">
        <h1>Find Your Property</h1>
        <p>Search verified listings for sale and rent across Pakistan's top cities.</p>
    </div>

    <form id="filterForm" action="/properties" method="get" class="search-toolbar">
        <div class="purpose-toggle" data-purpose-toggle>
            <button type="button" data-val="">All</button>
            <button type="button" data-val="sale">Buy</button>
            <button type="button" data-val="rent">Rent</button>
        </div>
        <input type="hidden" name="purpose" id="purposeInput" value="<?= e($filters['purpose']) ?>">

        <div class="search-toolbar-row">
            <div class="search-toolbar-fields">
                <select class="form-control" name="city">
                    <option value="">Any City</option>
                    <?php foreach ($cities as $c): ?><option value="<?= e($c['slug']) ?>" <?= $filters['city'] === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
                </select>
                <select class="form-control" name="type">
                    <option value="">Any Type</option>
                    <?php foreach ($types as $t): ?><option value="<?= e($t['slug']) ?>" <?= $filters['type'] === $t['slug'] ? 'selected' : '' ?>><?= e($t['name']) ?></option><?php endforeach; ?>
                </select>
                <div class="price-range-field">
                    <input class="form-control" type="number" name="min_price" placeholder="Min price" value="<?= e($filters['min_price']) ?>">
                    <span>–</span>
                    <input class="form-control" type="number" name="max_price" placeholder="Max price" value="<?= e($filters['max_price']) ?>">
                </div>
            </div>

            <div class="search-toolbar-actions">
                <button type="button" class="btn btn-secondary" id="moreFiltersBtn" aria-expanded="false">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                    More Filters
                </button>
                <button class="btn btn-primary" type="submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
                    Search
                </button>
            </div>
        </div>

        <div class="more-filters-panel" id="moreFiltersPanel">
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
        </div>
    </form>

    <div class="results-toolbar">
        <div id="resultsCountSlot"><?= (int) $pagination['total'] ?> propert<?= $pagination['total'] === 1 ? 'y' : 'ies' ?> found</div>
        <div class="sort-inline">
            <label class="form-label" for="sortSelect">Sort</label>
            <select class="form-control" id="sortSelect" name="sort" form="filterForm">
                <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest First</option>
                <option value="price_asc" <?= $filters['sort'] === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_desc" <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
            </select>
        </div>
    </div>

    <div id="resultsContainer">
        <?php view('pages/_properties-results', ['items' => $items, 'pagination' => $pagination, 'showCount' => false]); ?>
    </div>
</div>

<script src="<?= asset('js/filters.js') ?>"></script>
<?php view('layouts/site-footer'); ?>
