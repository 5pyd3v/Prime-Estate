(function () {
    var grid = document.getElementById('imageReorderGrid');
    if (!grid) return;

    var entity = grid.dataset.entity || 'properties';
    var propertyId = grid.dataset.propertyId || grid.dataset.projectId;
    var csrfInput = document.getElementById('csrfToken');
    var csrf = csrfInput ? csrfInput.value : '';
    var dragEl = null;

    function sendOrder() {
        var ids = Array.prototype.map.call(grid.children, function (el) { return el.dataset.imageId; });
        fetch('/admin/' + entity + '/' + propertyId + '/images/reorder', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ order: ids, _csrf: csrf })
        }).catch(function () {});
    }

    Array.prototype.forEach.call(grid.children, initItem);

    function initItem(item) {
        item.addEventListener('dragstart', function () {
            dragEl = item;
            item.classList.add('dragging');
        });
        item.addEventListener('dragend', function () {
            item.classList.remove('dragging');
            sendOrder();
        });
        item.addEventListener('dragover', function (e) {
            e.preventDefault();
            var after = getDragAfterElement(grid, e.clientY, e.clientX);
            if (!dragEl) return;
            if (after == null) {
                grid.appendChild(dragEl);
            } else {
                grid.insertBefore(dragEl, after);
            }
        });

        var primaryBtn = item.querySelector('.set-primary-btn');
        if (primaryBtn) {
            primaryBtn.addEventListener('click', function () {
                var imageId = item.dataset.imageId;
                var fd = new FormData();
                fd.append('_csrf', csrf);
                fetch('/admin/' + entity + '/' + propertyId + '/images/' + imageId + '/primary', { method: 'POST', body: fd })
                    .then(function () {
                        grid.querySelectorAll('.primary-tag').forEach(function (t) { t.remove(); });
                        var tag = document.createElement('span');
                        tag.className = 'primary-tag';
                        tag.textContent = 'Primary';
                        item.appendChild(tag);
                        if (typeof showToast === 'function') showToast('Primary image updated', 'success');
                    });
            });
        }

        var deleteBtn = item.querySelector('.delete-image-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function () {
                if (!confirm('Remove this image?')) return;
                var imageId = item.dataset.imageId;
                var fd = new FormData();
                fd.append('_csrf', csrf);
                fetch('/admin/' + entity + '/' + propertyId + '/images/' + imageId + '/delete', { method: 'POST', body: fd })
                    .then(function () {
                        item.remove();
                        if (typeof showToast === 'function') showToast('Image removed', 'success');
                    });
            });
        }
    }

    function getDragAfterElement(container, y, x) {
        var items = Array.prototype.slice.call(container.querySelectorAll('.image-reorder-item:not(.dragging)'));
        var closest = { offset: Number.NEGATIVE_INFINITY, element: null };
        items.forEach(function (child) {
            var box = child.getBoundingClientRect();
            var offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                closest = { offset: offset, element: child };
            }
        });
        return closest.element;
    }
})();
