<?php
/** @var array $stats */
/** @var array $recentInquiries */
/** @var array $recentProperties */
/** @var array $monthly */
ob_start();

$cards = [
    ['label' => 'Total Properties', 'value' => $stats['properties_total'], 'icon' => 'home', 'color' => '#EEF0FE', 'fg' => '#2A3B8F'],
    ['label' => 'Published', 'value' => $stats['properties_published'], 'icon' => 'check-square', 'color' => '#E9F3EC', 'fg' => '#1E5E33'],
    ['label' => 'Featured', 'value' => $stats['properties_featured'], 'icon' => 'star', 'color' => '#FFF4E5', 'fg' => '#A15C00'],
    ['label' => 'Sold', 'value' => $stats['properties_sold'], 'icon' => 'briefcase', 'color' => '#F1EFEA', 'fg' => '#55534B'],
    ['label' => 'Rented', 'value' => $stats['properties_rented'], 'icon' => 'building', 'color' => '#EAF1FB', 'fg' => '#1E4E8C'],
    ['label' => 'New Inquiries', 'value' => $stats['inquiries_new'], 'icon' => 'inbox', 'color' => '#FBEAE8', 'fg' => '#A32E20'],
    ['label' => 'Agents', 'value' => $stats['agents_total'], 'icon' => 'user', 'color' => '#EEF0FE', 'fg' => '#2A3B8F'],
    ['label' => 'Projects', 'value' => $stats['projects_total'], 'icon' => 'building', 'color' => '#E9F3EC', 'fg' => '#1E5E33'],
    ['label' => 'Blog Posts', 'value' => $stats['blog_total'], 'icon' => 'file-text', 'color' => '#FFF4E5', 'fg' => '#A15C00'],
    ['label' => 'Unread Messages', 'value' => $stats['messages_unread'], 'icon' => 'mail', 'color' => '#FBEAE8', 'fg' => '#A32E20'],
];
$svgIcons = [
    'home' => '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/>',
    'check-square' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 12l3 3 5-6"/>',
    'star' => '<path d="M12 3l2.6 5.9 6.4.6-4.8 4.2 1.5 6.3L12 16.9 6.3 20l1.5-6.3-4.8-4.2 6.4-.6z"/>',
    'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>',
    'building' => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 8h1M14 8h1M9 12h1M14 12h1M9 16h1M14 16h1"/>',
    'inbox' => '<path d="M4 4h16l-1 12H5z"/><path d="M4 16l3-6h10l3 6"/>',
    'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>',
    'file-text' => '<path d="M6 2h9l5 5v15H6z"/><path d="M9 13h6M9 17h6M9 9h2"/>',
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
];
?>
<div class="stat-grid">
    <?php foreach ($cards as $c): ?>
        <div class="stat-card">
            <div class="stat-icon" style="background:<?= $c['color'] ?>;color:<?= $c['fg'] ?>;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><?= $svgIcons[$c['icon']] ?></svg>
            </div>
            <div class="stat-label"><?= e($c['label']) ?></div>
            <div class="stat-value"><?= (int) $c['value'] ?></div>
        </div>
    <?php endforeach; ?>
</div>

<div class="two-col">
    <div>
        <div class="panel">
            <div class="panel-head">
                <h2>New Listings (Last 6 Months)</h2>
            </div>
            <canvas id="listingsChart" height="220" data-points='<?= e(json_encode($monthly)) ?>'></canvas>
        </div>

        <div class="panel">
            <div class="panel-head">
                <h2>Recent Properties</h2>
                <a href="/admin/properties">View all</a>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Property</th><th>City</th><th>Purpose</th><th>Price</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach ($recentProperties as $p): ?>
                        <tr>
                            <td><a href="/admin/properties/<?= (int) $p['id'] ?>/edit"><?= e($p['title']) ?></a></td>
                            <td><?= e($p['city_name'] ?? '—') ?></td>
                            <td><span class="badge badge-<?= e($p['purpose']) ?>"><?= e(ucfirst($p['purpose'])) ?></span></td>
                            <td><?= format_money($p['price']) ?></td>
                            <td><span class="badge badge-neutral"><?= e(ucfirst($p['status'])) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$recentProperties): ?><tr><td colspan="5">No properties yet.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="panel-head">
                <h2>Recent Inquiries</h2>
                <a href="/admin/inquiries">View all</a>
            </div>
            <?php foreach ($recentInquiries as $inq): ?>
                <div style="padding:10px 0;border-bottom:1px solid var(--admin-border);">
                    <div style="display:flex;justify-content:space-between;">
                        <strong style="font-size:13.5px;"><?= e($inq['name']) ?></strong>
                        <span class="badge badge-<?= $inq['status'] === 'new' ? 'new' : 'neutral' ?>"><?= e(ucfirst($inq['status'])) ?></span>
                    </div>
                    <div style="font-size:12.5px;color:var(--admin-muted);margin-top:2px;">
                        <?= e($inq['property_title'] ?? 'General inquiry') ?> · <?= time_ago($inq['created_at']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!$recentInquiries): ?><p style="color:var(--admin-muted);font-size:13px;">No inquiries yet.</p><?php endif; ?>
        </div>
    </div>
</div>

<script>
(function(){
    var canvas = document.getElementById('listingsChart');
    if (!canvas) return;
    var points = JSON.parse(canvas.dataset.points || '[]');
    var ctx = canvas.getContext('2d');
    var w = canvas.width = canvas.offsetWidth;
    var h = canvas.height = 220;
    var max = Math.max(1, ...points.map(function(p){ return parseInt(p.total, 10); }));
    var padding = 30;
    var barWidth = points.length ? (w - padding * 2) / points.length : 0;

    ctx.clearRect(0, 0, w, h);
    ctx.strokeStyle = '#E6E8EC';
    ctx.beginPath(); ctx.moveTo(padding, h - padding); ctx.lineTo(w - 10, h - padding); ctx.stroke();

    points.forEach(function(p, i){
        var val = parseInt(p.total, 10);
        var barH = (val / max) * (h - padding * 2 - 20);
        var x = padding + i * barWidth + barWidth * 0.2;
        var barW = barWidth * 0.6;
        var y = h - padding - barH;
        ctx.fillStyle = '#2A3B8F';
        ctx.beginPath();
        ctx.roundRect(x, y, barW, barH, 5);
        ctx.fill();
        ctx.fillStyle = '#6B7280';
        ctx.font = '11px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(p.ym.slice(5), x + barW / 2, h - padding + 16);
        ctx.fillStyle = '#1B1E23';
        ctx.fillText(val, x + barW / 2, y - 6);
    });
})();
</script>
<?php
$content = ob_get_clean();
view('layouts/admin-shell', ['title' => 'Dashboard', 'active' => 'dashboard', 'content' => $content]);
