(function () {
    var shell = document.getElementById('adminShell');
    var sidebarToggle = document.getElementById('sidebarToggle');
    var mobileToggle = document.getElementById('mobileSidebarToggle');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            shell.classList.toggle('collapsed');
            localStorage.setItem('admin_sidebar_collapsed', shell.classList.contains('collapsed') ? '1' : '0');
        });
        if (localStorage.getItem('admin_sidebar_collapsed') === '1') {
            shell.classList.add('collapsed');
        }
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function () {
            shell.classList.toggle('mobile-open');
        });
    }

    document.addEventListener('click', function (e) {
        if (shell.classList.contains('mobile-open') && !e.target.closest('.admin-sidebar') && !e.target.closest('#mobileSidebarToggle')) {
            shell.classList.remove('mobile-open');
        }
    });

    // Generic confirm-delete forms
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm(form.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });

    // Generic modal open/close via data attributes
    document.querySelectorAll('[data-modal-open]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var modal = document.getElementById(btn.dataset.modalOpen);
            if (modal) modal.classList.add('open');
        });
    });
    document.querySelectorAll('[data-modal-close]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var modal = btn.closest('.modal-backdrop');
            if (modal) modal.classList.remove('open');
        });
    });
    document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) backdrop.classList.remove('open');
        });
    });

    // Tabs
    document.querySelectorAll('[data-tabs]').forEach(function (tabBar) {
        var target = document.getElementById(tabBar.dataset.tabs);
        if (!target) return;
        var links = tabBar.querySelectorAll('.tab-link');
        links.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                links.forEach(function (l) { l.classList.remove('active'); });
                link.classList.add('active');
                target.querySelectorAll('[data-tab-panel]').forEach(function (p) {
                    p.style.display = p.dataset.tabPanel === link.dataset.tab ? 'block' : 'none';
                });
            });
        });
    });
})();
