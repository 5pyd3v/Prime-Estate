(function () {
    function stack() {
        return document.getElementById('toastStack');
    }

    window.showToast = function (message, type) {
        var s = stack();
        if (!s) return;
        var el = document.createElement('div');
        el.className = 'toast toast-' + (type || 'success');
        el.textContent = message;
        s.appendChild(el);
        requestAnimationFrame(function () { el.classList.add('show'); });
        setTimeout(function () {
            el.classList.remove('show');
            setTimeout(function () { el.remove(); }, 250);
        }, 3500);
    };
})();
