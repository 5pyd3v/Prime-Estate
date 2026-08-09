(function () {
    var form = document.getElementById('filterForm');
    var results = document.getElementById('resultsContainer');
    if (!form || !results) return;

    var sortSelect = form.querySelector('[name="sort"]');
    var loadingHtml = '<div style="padding:80px 0;text-align:center;color:#999;">Loading…</div>';

    function submitFilters(pushState) {
        var params = new URLSearchParams(new FormData(form));
        Array.from(params.keys()).forEach(function (key) {
            if (!params.get(key)) params.delete(key);
        });
        var query = params.toString();
        var url = form.getAttribute('action') + (query ? '?' + query : '');

        results.style.opacity = '0.5';

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                results.innerHTML = html;
                results.style.opacity = '1';
                if (pushState !== false) {
                    history.pushState({}, '', url);
                }
                window.scrollTo({ top: results.offsetTop - 130, behavior: 'smooth' });
            })
            .catch(function () {
                window.location.href = url;
            });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitFilters();
    });

    form.querySelectorAll('select').forEach(function (el) {
        el.addEventListener('change', function () { submitFilters(); });
    });

    document.addEventListener('click', function (e) {
        var link = e.target.closest('#resultsContainer .pagination a');
        if (!link) return;
        e.preventDefault();
        var url = link.getAttribute('href');
        results.style.opacity = '0.5';
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                results.innerHTML = html;
                results.style.opacity = '1';
                history.pushState({}, '', url);
                window.scrollTo({ top: results.offsetTop - 130, behavior: 'smooth' });
            });
    });
})();
