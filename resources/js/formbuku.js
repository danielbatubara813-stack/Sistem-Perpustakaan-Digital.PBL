// JavaScript for resources/views/admin/buku/form-buku.blade.php
// Moved from public/js/formbuku.js. Use with Vite: @vite('resources/js/formbuku.js')

const kode1 = document.getElementById('kode_1');
const kode2 = document.getElementById('kode_2');

// 🔹 No Rak → No Panggil
const noRakEl = document.getElementById('no_rak');
if (noRakEl) {
    noRakEl.addEventListener('input', function() {
        const p = document.getElementById('no_panggil_1');
        if (p) p.value = this.value;
    });
}

// 🔹 Random 4 karakter
function randomCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = '';
    for (let i = 0; i < 4; i++) {
        result += chars[Math.floor(Math.random() * chars.length)];
    }
    return result;
}

// 🔹 Format 0001
// 🔹 Generate kode 1 & 2
function generateKode12() {
    if (kode1) kode1.value = randomCode();
    if (kode2) kode2.value = randomCode();
}

// 🔹 Update kode 3
// 🔹 Uppercase + limit 4
function enforce(el) {
    if (!el) return;
    el.addEventListener('input', function() {
        this.value = this.value.toUpperCase().slice(0, 4);
    });
}

enforce(kode1);
enforce(kode2);

// 🔹 Event
const regenBtn = document.getElementById('regenBtn');
if (regenBtn) regenBtn.addEventListener('click', generateKode12);

// 🔹 Preview gambar
const coverInput = document.getElementById('coverInput');
if (coverInput) {
    coverInput.addEventListener('change', function() {
        const file = this.files[0];
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');

        if (!file) return;

        if (file.size > 10 * 1024 * 1024) {
            alert('File terlalu besar (maks 10MB)');
            this.value = '';
            return;
        }

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            alert('Format harus JPG atau PNG');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
}

// 🔹 Init
if (typeof kode1 !== 'undefined' && typeof kode2 !== 'undefined') {
    const k1 = document.getElementById('kode_1');
    const k2 = document.getElementById('kode_2');
    if (k1 && k2 && (!k1.value || !k2.value)) generateKode12();
}

// ensure preview visible when editing existing book with cover
const previewImg = document.getElementById('preview');
const placeholderSpan = document.getElementById('placeholder');
if (previewImg && previewImg.getAttribute('src') && previewImg.getAttribute('src').trim() !== '') {
    previewImg.classList.remove('hidden');
    if (placeholderSpan) placeholderSpan.classList.add('hidden');
}

// 🔹 Penulis selection handling
const penulisSelect = document.getElementById('penulis_select');
const tipePenulisSelect = document.getElementById('tipe_penulis_select');
const addPenulisBtn = document.getElementById('addPenulisBtn');
const manualNameInput = document.getElementById('manual_nama_penulis');
const manualTipeSelect = document.getElementById('manual_tipe_penulis');
const selectedAuthorsContainer = document.getElementById('selected-authors');

if (penulisSelect && tipePenulisSelect) {
    penulisSelect.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (opt) {
            tipePenulisSelect.value = opt.dataset.tipe || '';
        }
    });
}

// Toggle visibility between automatic tipe (when selecting existing penulis)
// and manual tipe (when typing a new penulis name)
function updateTipeVisibility() {
    const autoGroup = document.getElementById('tipe_auto_group');
    const manualGroup = document.getElementById('tipe_manual_group');
    const hasManualName = manualNameInput && manualNameInput.value.trim().length > 0;
    const hasSelectedPenulis = penulisSelect && penulisSelect.value;

    if (hasManualName) {
        if (manualGroup) manualGroup.classList.remove('hidden');
        if (autoGroup) autoGroup.classList.add('hidden');
    } else if (hasSelectedPenulis) {
        if (manualGroup) manualGroup.classList.add('hidden');
        if (autoGroup) autoGroup.classList.remove('hidden');
        // set the automatic tipe value
        const opt = penulisSelect.options[penulisSelect.selectedIndex];
        if (opt && tipePenulisSelect) tipePenulisSelect.value = opt.dataset.tipe || '';
    } else {
        // default: show manual input for new names
        if (manualGroup) manualGroup.classList.remove('hidden');
        if (autoGroup) autoGroup.classList.add('hidden');
    }
}

if (penulisSelect) penulisSelect.addEventListener('change', updateTipeVisibility);
if (manualNameInput) manualNameInput.addEventListener('input', updateTipeVisibility);
// initialize visibility on load
updateTipeVisibility();

function addAuthorChip(id, name, tipe) {
    if (!id) return;
    // avoid duplicates
    if (selectedAuthorsContainer && selectedAuthorsContainer.querySelector('.author-chip[data-id="' + id + '"]')) return;

    // remove placeholder text if exists
    const placeholder = selectedAuthorsContainer ? selectedAuthorsContainer.querySelector('p') : null;
    if (placeholder) placeholder.remove();

    const wrapper = document.createElement('div');
    wrapper.className = 'author-chip flex items-center justify-between gap-2 my-1';
    wrapper.setAttribute('data-id', id);

    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'id_penulis[]';
    hidden.value = id;

    const label = document.createElement('span');
    label.className = 'text-sm';
    label.innerHTML = name + ' <small class="text-xs text-gray-500">(' + (tipe || '-') + ')</small>';

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'text-red-600 ml-2 remove-author';
    btn.innerText = 'Hapus';
    btn.addEventListener('click', function() {
        wrapper.remove();
        // if no more chips, show placeholder
        if (selectedAuthorsContainer && !selectedAuthorsContainer.querySelector('.author-chip')) {
            const p = document.createElement('p');
            p.className = 'text-sm text-gray-500';
            p.innerText = 'Belum ada penulis dipilih.';
            selectedAuthorsContainer.appendChild(p);
        }
    });

    wrapper.appendChild(hidden);
    wrapper.appendChild(label);
    wrapper.appendChild(btn);

    if (selectedAuthorsContainer) selectedAuthorsContainer.appendChild(wrapper);
}

if (addPenulisBtn) {
    addPenulisBtn.addEventListener('click', async function() {
        // if manual name provided, create via AJAX then add
        const manualName = manualNameInput ? manualNameInput.value.trim() : '';
        const manualTipe = manualTipeSelect ? manualTipeSelect.value : '';
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const token = csrfMeta ? csrfMeta.getAttribute('content') : '';

        if (manualName) {
            try {
                const res = await fetch('/admin/data-terkendali/penulis', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ nama_penulis: manualName, tipe_penulis: manualTipe })
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    if (data.errors) {
                        const msgs = Object.values(data.errors).flat().join('\n');
                        alert(msgs);
                    } else if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Gagal menambahkan penulis');
                    }
                    return;
                }

                const p = data.penulis;
                if (p && penulisSelect) {
                    const opt = document.createElement('option');
                    opt.value = p.id_penulis;
                    opt.dataset.tipe = p.tipe_penulis;
                    opt.textContent = p.nama_penulis;
                    penulisSelect.appendChild(opt);
                }

                if (p) addAuthorChip(p.id_penulis, p.nama_penulis, p.tipe_penulis);

                if (manualNameInput) manualNameInput.value = '';

                const hideBtn = document.querySelector('[data-modal-hide="modal-penulis"]');
                if (hideBtn) hideBtn.click();
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat menyimpan penulis.');
            }

            return;
        }

        // fallback: add selected existing penulis
        const sel = penulisSelect;
        if (!sel) return;
        const id = sel.value;
        if (!id) {
            alert('Pilih penulis terlebih dahulu atau ketik nama baru');
            return;
        }
        const name = sel.options[sel.selectedIndex].text;
        const tipe = sel.options[sel.selectedIndex].dataset.tipe || '';
        addAuthorChip(id, name, tipe);

        // close modal if library provided a hide button
        const hideBtn = document.querySelector('[data-modal-hide="modal-penulis"]');
        if (hideBtn) hideBtn.click();
    });
}

// delegate remove clicks for any prepopulated remove buttons
if (selectedAuthorsContainer) {
    selectedAuthorsContainer.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-author')) {
            const chip = e.target.closest('.author-chip');
            if (chip) chip.remove();
            if (!selectedAuthorsContainer.querySelector('.author-chip')) {
                const p = document.createElement('p');
                p.className = 'text-sm text-gray-500';
                p.innerText = 'Belum ada penulis dipilih.';
                selectedAuthorsContainer.appendChild(p);
            }
        }
    });
}
