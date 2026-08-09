(function () {
    /* Navbar scroll + mobile menu */
    var header = document.querySelector('.site-header');
    if (header) {
        var onScroll = function () {
            if (window.scrollY > 40) header.classList.add('nav-scrolled');
            else header.classList.remove('nav-scrolled');
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    var hamburger = document.getElementById('navHamburger');
    var mobilePanel = document.getElementById('mobileNavPanel');
    var mobileClose = document.getElementById('mobileNavClose');
    if (hamburger && mobilePanel) {
        hamburger.addEventListener('click', function () { mobilePanel.classList.add('open'); document.body.style.overflow = 'hidden'; });
    }
    if (mobileClose && mobilePanel) {
        mobileClose.addEventListener('click', function () { mobilePanel.classList.remove('open'); document.body.style.overflow = ''; });
    }

    /* Hero slideshow */
    var slides = document.querySelectorAll('.hero-slide');
    if (slides.length > 1) {
        var idx = 0;
        setInterval(function () {
            slides[idx].classList.remove('active');
            idx = (idx + 1) % slides.length;
            slides[idx].classList.add('active');
        }, 5500);
    }

    /* Favorites (localStorage) */
    function getFavorites() {
        try { return JSON.parse(localStorage.getItem('recms_favorites') || '[]'); } catch (e) { return []; }
    }
    function setFavorites(arr) { localStorage.setItem('recms_favorites', JSON.stringify(arr)); }

    document.querySelectorAll('.fav-btn').forEach(function (btn) {
        var id = btn.dataset.propertyId;
        if (getFavorites().indexOf(id) !== -1) btn.classList.add('active');
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var favs = getFavorites();
            var i = favs.indexOf(id);
            if (i === -1) { favs.push(id); btn.classList.add('active'); if (typeof showToast === 'function') showToast('Added to favorites', 'success'); }
            else { favs.splice(i, 1); btn.classList.remove('active'); if (typeof showToast === 'function') showToast('Removed from favorites', 'success'); }
            setFavorites(favs);
        });
    });

    /* FAQ accordion */
    document.querySelectorAll('.faq-question').forEach(function (q) {
        q.addEventListener('click', function () {
            var item = q.closest('.faq-item');
            item.classList.toggle('open');
        });
    });

    /* Simple contact / inquiry form AJAX submit with validation */
    document.querySelectorAll('form[data-ajax-form]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var btn = form.querySelector('button[type="submit"]');
            var originalText = btn ? btn.textContent : '';
            if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

            fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.ok) {
                        if (typeof showToast === 'function') showToast(data.message || 'Sent successfully!', 'success');
                        form.reset();
                        if (form.dataset.successRedirect) window.location.href = form.dataset.successRedirect;
                    } else {
                        if (typeof showToast === 'function') showToast(data.message || 'Something went wrong.', 'error');
                    }
                })
                .catch(function () {
                    if (typeof showToast === 'function') showToast('Something went wrong. Please try again.', 'error');
                })
                .finally(function () {
                    if (btn) { btn.disabled = false; btn.textContent = originalText; }
                });
        });
    });
})();
