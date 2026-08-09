(function () {
    var form = document.getElementById('filterForm');
    var results = document.getElementById('resultsContainer');
    if (!form || !results) return;

    var countSlot = document.getElementById('resultsCountSlot');

    function pluralize(n) {
        return n + ' propert' + (n === 1 ? 'y' : 'ies') + ' found';
    }

    function updateCountFromResults() {
        if (!countSlot) return;
        var meta = results.querySelector('#resultsMeta');
        if (meta) countSlot.textContent = pluralize(parseInt(meta.dataset.total, 10) || 0);
    }

    function collectParams() {
        var params = new URLSearchParams(new FormData(form));
        // Pick up fields associated to the form via the `form` attribute but not nested inside it (e.g. sort select).
        document.querySelectorAll('[form="' + form.id + '"]').forEach(function (el) {
            if (el.name) params.set(el.name, el.value);
        });
        Array.from(params.keys()).forEach(function (key) {
            if (!params.get(key)) params.delete(key);
        });
        return params;
    }

    function submitFilters(pushState) {
        var query = collectParams().toString();
        var url = form.getAttribute('action') + (query ? '?' + query : '');

        results.style.opacity = '0.5';

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                results.innerHTML = html;
                results.style.opacity = '1';
                updateCountFromResults();
                if (pushState !== false) {
                    history.pushState({}, '', url);
                }
                window.scrollTo({ top: results.offsetTop - 130, behavior: 'smooth' });
            })
            .catch(function () {
                window.location.href = url;
            });
    }

    /* Filters only apply when the Search button is pressed — no live/instant refresh
       while the customer is still choosing options. */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitFilters();
    });

    /* Purpose segmented toggle — just updates the pending selection, does not search yet */
    var purposeToggle = document.querySelector('[data-purpose-toggle]');
    var purposeInput = document.getElementById('purposeInput');
    if (purposeToggle && purposeInput) {
        var syncActive = function () {
            purposeToggle.querySelectorAll('button').forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.val === purposeInput.value);
            });
        };
        purposeToggle.querySelectorAll('button').forEach(function (btn) {
            btn.addEventListener('click', function () {
                purposeInput.value = btn.dataset.val;
                syncActive();
            });
        });
        syncActive();
    }

    /* More filters collapsible panel */
    var moreBtn = document.getElementById('moreFiltersBtn');
    var morePanel = document.getElementById('moreFiltersPanel');
    if (moreBtn && morePanel) {
        var hasActiveMoreFilters = morePanel.querySelectorAll('select').length &&
            Array.from(morePanel.querySelectorAll('select')).some(function (s) { return s.value; });
        if (hasActiveMoreFilters) {
            morePanel.classList.add('open');
            moreBtn.setAttribute('aria-expanded', 'true');
        }
        moreBtn.addEventListener('click', function () {
            var open = morePanel.classList.toggle('open');
            moreBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

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
                updateCountFromResults();
                history.pushState({}, '', url);
                window.scrollTo({ top: results.offsetTop - 130, behavior: 'smooth' });
            });
    });
})();
