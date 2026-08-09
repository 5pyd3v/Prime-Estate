(function () {
    var modal = document.getElementById('mediaPickerModal');
    if (!modal) return;

    var grid = document.getElementById('mediaGrid');
    var searchInput = document.getElementById('mediaSearchInput');
    var uploadBtn = document.getElementById('mediaUploadBtn');
    var uploadInput = document.getElementById('mediaUploadInput');
    var dropzone = document.getElementById('mediaDropzone');
    var csrfToken = document.getElementById('csrfToken');
    var currentField = null;
    var currentType = 'image';
    var searchTimer = null;

    function csrf() { return csrfToken ? csrfToken.value : ''; }

    function loadItems(query) {
        grid.innerHTML = '<p style="color:#999;font-size:13px;">Loading…</p>';
        var url = '/admin/media/picker?type=' + encodeURIComponent(currentType) + (query ? '&q=' + encodeURIComponent(query) : '');
        fetch(url).then(function (r) { return r.json(); }).then(function (data) {
            renderGrid(data.items || []);
        });
    }

    function renderGrid(items) {
        grid.innerHTML = '';
        if (!items.length) {
            grid.innerHTML = '<p style="color:#999;font-size:13px;">No media found.</p>';
            return;
        }
        items.forEach(function (item) {
            var tile = document.createElement('div');
            tile.className = 'media-tile';
            if (item.type === 'image') {
                tile.innerHTML = '<img src="' + item.url + '" alt="" loading="lazy">';
            } else {
                tile.innerHTML = '<div class="doc-tile">' + (item.name || 'File') + '</div>';
            }
            tile.addEventListener('click', function () { selectItem(item); });
            grid.appendChild(tile);
        });
    }

    function selectItem(item) {
        if (!currentField) return;
        var input = currentField.querySelector('.media-field-input');
        var img = currentField.querySelector('.media-field-img');
        var empty = currentField.querySelector('.media-field-empty');
        input.value = item.id;
        if (img) { img.src = item.url; img.style.display = 'block'; }
        if (empty) empty.style.display = 'none';
        modal.classList.remove('open');
    }

    document.querySelectorAll('[data-media-choose]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            currentField = btn.closest('[data-media-field]');
            currentType = currentField ? (currentField.dataset.type || 'image') : 'image';
            searchInput.value = '';
            modal.classList.add('open');
            loadItems('');
        });
    });

    document.querySelectorAll('[data-media-clear]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var field = btn.closest('[data-media-field]');
            var input = field.querySelector('.media-field-input');
            var img = field.querySelector('.media-field-img');
            var empty = field.querySelector('.media-field-empty');
            input.value = 0;
            if (img) img.style.display = 'none';
            if (empty) empty.style.display = 'block';
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () { loadItems(searchInput.value); }, 350);
        });
    }

    function uploadFile(file) {
        var fd = new FormData();
        fd.append('file', file);
        fd.append('_csrf', csrf());
        grid.insertAdjacentHTML('afterbegin', '<div class="media-tile" id="uploadingTile" style="display:flex;align-items:center;justify-content:center;font-size:11px;color:#999;">Uploading…</div>');
        fetch('/admin/media/upload', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var tile = document.getElementById('uploadingTile');
                if (tile) tile.remove();
                if (data.item) {
                    if (typeof showToast === 'function') showToast('File uploaded', 'success');
                    selectItem(data.item);
                    loadItems('');
                } else if (data.error) {
                    if (typeof showToast === 'function') showToast(data.error, 'error');
                }
            });
    }

    if (uploadBtn) {
        uploadBtn.addEventListener('click', function () { uploadInput.click(); });
        uploadInput.addEventListener('change', function () {
            if (uploadInput.files[0]) uploadFile(uploadInput.files[0]);
        });
    }

    if (dropzone) {
        ['dragover', 'dragenter'].forEach(function (evt) {
            dropzone.addEventListener(evt, function (e) { e.preventDefault(); dropzone.classList.add('dragover'); });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            dropzone.addEventListener(evt, function (e) { e.preventDefault(); dropzone.classList.remove('dragover'); });
        });
        dropzone.addEventListener('drop', function (e) {
            if (e.dataTransfer.files[0]) uploadFile(e.dataTransfer.files[0]);
        });
    }
})();
