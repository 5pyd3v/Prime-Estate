<?php
/** @var array|null $property */
/** @var array $types */
/** @var array $cities */
/** @var array $features */
/** @var array $selectedFeatures */
/** @var array $images */
$p = $property ?? [];
function pv(array $p, string $key, string $default = ''): string
{
    return e((string) ($p[$key] ?? $default));
}
$allAreas = Area::all('sort_order, name');
$isEdit = $property !== null;
$activeTab = 'basic';
?>
<form method="post" action="<?= $isEdit ? '/admin/properties/' . (int) $p['id'] . '/update' : '/admin/properties/store' ?>" enctype="multipart/form-data" id="propertyForm">
    <?= Csrf::field() ?>

    <div class="tab-bar" data-tabs="propertyTabs">
        <a href="#" class="tab-link active" data-tab="basic">Basic</a>
        <a href="#" class="tab-link" data-tab="location">Location</a>
        <a href="#" class="tab-link" data-tab="specs">Specifications</a>
        <a href="#" class="tab-link" data-tab="description">Description</a>
        <a href="#" class="tab-link" data-tab="features">Features</a>
        <a href="#" class="tab-link" data-tab="media">Media<?= $isEdit ? ' (' . count($images) . ')' : '' ?></a>
        <a href="#" class="tab-link" data-tab="seo">SEO</a>
    </div>

    <div id="propertyTabs">
        <div class="panel" data-tab-panel="basic">
            <div class="form-group"><label class="form-label">Property Title *</label><input class="form-control" name="title" value="<?= pv($p, 'title') ?>" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Property Type</label>
                    <select class="form-control" name="property_type_id">
                        <option value="">Select type</option>
                        <?php foreach ($types as $t): ?><option value="<?= (int) $t['id'] ?>" <?= (int) ($p['property_type_id'] ?? 0) === (int) $t['id'] ? 'selected' : '' ?>><?= e($t['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Purpose</label>
                    <select class="form-control" name="purpose">
                        <option value="sale" <?= ($p['purpose'] ?? 'sale') === 'sale' ? 'selected' : '' ?>>For Sale</option>
                        <option value="rent" <?= ($p['purpose'] ?? '') === 'rent' ? 'selected' : '' ?>>For Rent</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Price *</label><input class="form-control" type="number" step="0.01" name="price" value="<?= pv($p, 'price', '0') ?>" required></div>
                <div class="form-group"><label class="form-label">Price Label</label><input class="form-control" name="price_label" value="<?= pv($p, 'price_label') ?>" placeholder="/month"></div>
                <div class="form-group"><label class="form-label">Currency</label><input class="form-control" name="currency" value="<?= pv($p, 'currency', 'PKR') ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <?php foreach (['available' => 'Available', 'sold' => 'Sold', 'rented' => 'Rented', 'under_offer' => 'Under Offer'] as $val => $lbl): ?>
                            <option value="<?= $val ?>" <?= ($p['status'] ?? 'available') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Agent</label>
                    <select class="form-control" name="agent_id">
                        <option value="">Unassigned</option>
                        <?php foreach (Agent::active() as $a): ?><option value="<?= (int) $a['id'] ?>" <?= (int) ($p['agent_id'] ?? 0) === (int) $a['id'] ? 'selected' : '' ?>><?= e($a['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div style="display:flex;gap:24px;margin-top:6px;">
                <label class="chip-check"><input type="checkbox" name="is_featured" <?= !empty($p['is_featured']) ? 'checked' : '' ?>> Featured Property</label>
                <label class="chip-check"><input type="checkbox" name="is_published" <?= ($isEdit ? !empty($p['is_published']) : true) ? 'checked' : '' ?>> Published</label>
            </div>
        </div>

        <div class="panel" data-tab-panel="location" style="display:none;">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">City</label>
                    <select class="form-control" name="city_id" id="citySelect">
                        <option value="">Select city</option>
                        <?php foreach ($cities as $c): ?><option value="<?= (int) $c['id'] ?>" <?= (int) ($p['city_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Area</label>
                    <select class="form-control" name="area_id" id="areaSelect" data-selected="<?= (int) ($p['area_id'] ?? 0) ?>">
                        <option value="">Select area</option>
                    </select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Full Address</label><input class="form-control" name="address" value="<?= pv($p, 'address') ?>"></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Latitude</label><input class="form-control" name="latitude" value="<?= pv($p, 'latitude') ?>"></div>
                <div class="form-group"><label class="form-label">Longitude</label><input class="form-control" name="longitude" value="<?= pv($p, 'longitude') ?>"></div>
            </div>
            <div class="form-group"><label class="form-label">Google Maps URL</label><input class="form-control" name="map_url" value="<?= pv($p, 'map_url') ?>"></div>
        </div>

        <div class="panel" data-tab-panel="specs" style="display:none;">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Bedrooms</label><input class="form-control" type="number" name="bedrooms" value="<?= pv($p, 'bedrooms') ?>"></div>
                <div class="form-group"><label class="form-label">Bathrooms</label><input class="form-control" type="number" name="bathrooms" value="<?= pv($p, 'bathrooms') ?>"></div>
                <div class="form-group"><label class="form-label">Kitchens</label><input class="form-control" type="number" name="kitchens" value="<?= pv($p, 'kitchens') ?>"></div>
                <div class="form-group"><label class="form-label">Parking Spaces</label><input class="form-control" type="number" name="parking_spaces" value="<?= pv($p, 'parking_spaces') ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Floors</label><input class="form-control" type="number" name="floors" value="<?= pv($p, 'floors') ?>"></div>
                <div class="form-group"><label class="form-label">Year Built</label><input class="form-control" type="number" name="year_built" value="<?= pv($p, 'year_built') ?>"></div>
                <div class="form-group">
                    <label class="form-label">Furnished Status</label>
                    <select class="form-control" name="furnished_status">
                        <?php foreach (['unfurnished' => 'Unfurnished', 'semi_furnished' => 'Semi-Furnished', 'furnished' => 'Furnished'] as $val => $lbl): ?>
                            <option value="<?= $val ?>" <?= ($p['furnished_status'] ?? 'unfurnished') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Plot / Area Size</label><input class="form-control" name="area_size" value="<?= pv($p, 'area_size') ?>"></div>
                <div class="form-group"><label class="form-label">Area Unit</label><input class="form-control" name="area_unit" value="<?= pv($p, 'area_unit', 'Marla') ?>" placeholder="Marla / Kanal / Sq. Ft / Sq. Yd"></div>
                <div class="form-group"><label class="form-label">Covered Area (Sq. Ft)</label><input class="form-control" name="covered_area" value="<?= pv($p, 'covered_area') ?>"></div>
                <div class="form-group"><label class="form-label">Lot Area (Sq. Ft)</label><input class="form-control" name="lot_area" value="<?= pv($p, 'lot_area') ?>"></div>
            </div>
        </div>

        <div class="panel" data-tab-panel="description" style="display:none;">
            <div class="form-group"><label class="form-label">Short Description</label><textarea class="form-control" name="short_description" maxlength="500"><?= pv($p, 'short_description') ?></textarea></div>
            <div class="form-group"><label class="form-label">Full Description</label><textarea class="form-control" name="description" style="min-height:220px;"><?= pv($p, 'description') ?></textarea></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Video URL</label><input class="form-control" name="video_url" value="<?= pv($p, 'video_url') ?>"></div>
                <div class="form-group"><label class="form-label">Virtual Tour URL</label><input class="form-control" name="virtual_tour_url" value="<?= pv($p, 'virtual_tour_url') ?>"></div>
            </div>
        </div>

        <div class="panel" data-tab-panel="features" style="display:none;">
            <div class="chip-grid">
                <?php foreach ($features as $f): ?>
                    <label class="chip-check">
                        <input type="checkbox" name="features[]" value="<?= (int) $f['id'] ?>" <?= in_array((int) $f['id'], $selectedFeatures, true) ? 'checked' : '' ?>>
                        <?= e($f['name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="panel" data-tab-panel="media" style="display:none;">
            <?php if ($isEdit): ?>
                <label class="form-label">Gallery</label>
                <div class="image-reorder-grid" id="imageReorderGrid" data-property-id="<?= (int) $p['id'] ?>">
                    <?php foreach ($images as $img): ?>
                        <div class="image-reorder-item" draggable="true" data-image-id="<?= (int) $img['id'] ?>">
                            <img src="<?= e(media_url($img['path'])) ?>" alt="">
                            <?php if ($img['is_primary']): ?><span class="primary-tag">Primary</span><?php endif; ?>
                            <div class="img-actions">
                                <button type="button" class="set-primary-btn" title="Set as primary">★</button>
                                <button type="button" class="delete-image-btn" title="Delete">✕</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="form-hint" style="margin:10px 0 18px;">Drag images to reorder. Click ★ to set the primary photo shown on listing cards.</p>
            <?php endif; ?>
            <label class="form-label">Upload <?= $isEdit ? 'More ' : '' ?>Images</label>
            <input type="file" class="form-control" name="images[]" multiple accept="image/jpeg,image/png,image/webp">
            <div class="form-hint">JPG, PNG or WEBP. You can select multiple files at once.</div>
        </div>

        <div class="panel" data-tab-panel="seo" style="display:none;">
            <div class="form-group"><label class="form-label">SEO Title</label><input class="form-control" name="seo_title" value="<?= pv($p, 'seo_title') ?>"></div>
            <div class="form-group"><label class="form-label">Meta Description</label><textarea class="form-control" name="seo_description"><?= pv($p, 'seo_description') ?></textarea></div>
            <div class="form-group"><label class="form-label">Meta Keywords</label><input class="form-control" name="seo_keywords" value="<?= pv($p, 'seo_keywords') ?>"></div>
        </div>
    </div>

    <div style="display:flex;gap:10px;margin-top:6px;">
        <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Save Changes' : 'Create Property' ?></button>
        <a class="btn btn-secondary" href="/admin/properties">Cancel</a>
    </div>
</form>

<script>
var ALL_AREAS = <?= json_encode($allAreas) ?>;
(function () {
    var citySelect = document.getElementById('citySelect');
    var areaSelect = document.getElementById('areaSelect');
    function populateAreas() {
        var cityId = parseInt(citySelect.value || '0', 10);
        var selected = parseInt(areaSelect.dataset.selected || '0', 10);
        areaSelect.innerHTML = '<option value="">Select area</option>';
        ALL_AREAS.filter(function (a) { return parseInt(a.city_id, 10) === cityId; }).forEach(function (a) {
            var opt = document.createElement('option');
            opt.value = a.id;
            opt.textContent = a.name;
            if (parseInt(a.id, 10) === selected) opt.selected = true;
            areaSelect.appendChild(opt);
        });
    }
    if (citySelect && areaSelect) {
        citySelect.addEventListener('change', populateAreas);
        populateAreas();
    }
})();
</script>
<script src="<?= asset('js/gallery-reorder.js') ?>"></script>
