(function () {
    var triggers = document.querySelectorAll('[data-lightbox-trigger]');
    var lightbox = document.getElementById('lightbox');
    if (!triggers.length || !lightbox) return;

    var imgEl = lightbox.querySelector('img');
    var counterEl = lightbox.querySelector('.lightbox-counter');
    var images = JSON.parse((document.getElementById('galleryData') || {}).textContent || '[]');
    var current = 0;

    function show(i) {
        current = (i + images.length) % images.length;
        imgEl.src = images[current];
        if (counterEl) counterEl.textContent = (current + 1) + ' / ' + images.length;
    }

    triggers.forEach(function (t) {
        t.addEventListener('click', function () {
            show(parseInt(t.dataset.lightboxTrigger || '0', 10));
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
    });

    var closeBtn = lightbox.querySelector('.lightbox-close');
    var prevBtn = lightbox.querySelector('.lightbox-prev');
    var nextBtn = lightbox.querySelector('.lightbox-next');

    function close() { lightbox.classList.remove('open'); document.body.style.overflow = ''; }

    if (closeBtn) closeBtn.addEventListener('click', close);
    if (prevBtn) prevBtn.addEventListener('click', function () { show(current - 1); });
    if (nextBtn) nextBtn.addEventListener('click', function () { show(current + 1); });
    lightbox.addEventListener('click', function (e) { if (e.target === lightbox) close(); });

    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });
})();
