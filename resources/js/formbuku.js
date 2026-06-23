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

// 🔹 Penulis autocomplete + add handling (single input)
const penulisInput = document.getElementById('penulis_input');
const penulisSuggestions = document.getElementById('penulis_suggestions');
const selectedAuthorsContainer = document.getElementById('selected-authors');
const penulisModal = document.getElementById('penulis_modal');
const penulisModalOpenBtn = document.getElementById('penulis_modal_open');
const penulisModalCloseBtn = document.getElementById('penulis_modal_close');
const penulisModalCancelBtn = document.getElementById('penulis_modal_cancel');
const penulisTypeInput = document.getElementById('penulis_tipe_input');
const addPenulisBtn = document.getElementById('addPenulisBtn');

const ALL_PENULIS = (window.PENULIS_DATA || []).map(p => ({ id: String(p.id), nama: p.nama, tipe: p.tipe }));
const MIN_PENULIS_QUERY_LENGTH = 1;
let penulisActions = [];
let activePenulisIndex = -1;
let selectedPenulisAction = null;

function normalizePenulisName(value) {
    return (value || '').trim().toLowerCase();
}

function setPenulisSuggestionsOpen(isOpen) {
    if (penulisInput) {
        penulisInput.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        if (!isOpen) penulisInput.removeAttribute('aria-activedescendant');
    }
}

function isPenulisModalOpen() {
    return penulisModal && !penulisModal.classList.contains('hidden');
}

function setPenulisTypeState(action = null) {
    if (!penulisTypeInput) return;

    const isExisting = action && action.type === 'existing';
    if (isExisting) {
        penulisTypeInput.value = action.penulis.tipe || 'Nama Orang';
    }

    penulisTypeInput.disabled = Boolean(isExisting);
    penulisTypeInput.classList.toggle('bg-gray-100', Boolean(isExisting));
    penulisTypeInput.classList.toggle('text-slate-500', Boolean(isExisting));
}

function getPenulisTypeValue() {
    return (penulisTypeInput && penulisTypeInput.value) ? penulisTypeInput.value : 'Nama Orang';
}

function resetPenulisModalFields() {
    if (penulisInput) penulisInput.value = '';
    selectedPenulisAction = null;
    setPenulisTypeState(null);
    clearPenulisSuggestions();
}

function openPenulisModal() {
    if (!penulisModal) return;

    penulisModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    setTimeout(() => {
        if (penulisInput) penulisInput.focus();
    }, 0);
}

function closePenulisModal() {
    if (!penulisModal) return;

    penulisModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    resetPenulisModalFields();
}

function removeAuthorPlaceholder() {
    const placeholder = selectedAuthorsContainer ? selectedAuthorsContainer.querySelector('p') : null;
    if (placeholder) placeholder.remove();
}

function renderAuthorPlaceholderIfEmpty() {
    if (!selectedAuthorsContainer || selectedAuthorsContainer.querySelector('.author-chip')) return;

    const p = document.createElement('p');
    p.className = 'px-3 py-3 text-sm text-gray-500';
    p.innerText = 'Belum ada penulis dipilih.';
    selectedAuthorsContainer.appendChild(p);
}

function hasExistingAuthor(id) {
    return Boolean(
        selectedAuthorsContainer &&
        selectedAuthorsContainer.querySelector('.author-chip[data-id="' + String(id) + '"]')
    );
}

function hasNewAuthor(name) {
    if (!selectedAuthorsContainer) return false;

    const normalized = normalizePenulisName(name);

    return Array
        .from(selectedAuthorsContainer.querySelectorAll('.author-chip[data-name]'))
        .some(chip => chip.dataset.name === normalized);
}

function findExactPenulis(name) {
    const normalized = normalizePenulisName(name);

    return ALL_PENULIS.find(p => normalizePenulisName(p.nama) === normalized);
}

function isSamePenulisAction(first, second) {
    if (!first || !second || first.type !== second.type) return false;

    if (first.type === 'existing') {
        return String(first.penulis.id) === String(second.penulis.id);
    }

    return normalizePenulisName(first.name) === normalizePenulisName(second.name);
}

function isPenulisActionSelected(action) {
    if (isSamePenulisAction(action, selectedPenulisAction)) return true;

    if (action.type === 'existing') {
        return hasExistingAuthor(action.penulis.id);
    }

    return hasNewAuthor(action.name);
}

function selectedActionMatchesInput() {
    if (!selectedPenulisAction || !penulisInput) return false;

    const value = normalizePenulisName(penulisInput.value);

    if (selectedPenulisAction.type === 'existing') {
        return value === normalizePenulisName(selectedPenulisAction.penulis.nama);
    }

    return value === normalizePenulisName(selectedPenulisAction.name);
}

function createRemoveAuthorButton() {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'remove-author shrink-0 text-sm font-medium text-red-600 hover:text-red-700';
    btn.setAttribute('aria-label', 'Hapus penulis');
    btn.innerText = 'Hapus';

    return btn;
}

function refreshPenulisActiveRow() {
    if (!penulisSuggestions) return;

    let activeOptionId = '';

    Array.from(penulisSuggestions.children).forEach((row, index) => {
        const action = penulisActions[index];
        const isSelected = action ? isPenulisActionSelected(action) : row.dataset.selected === 'true';
        const isActive = index === activePenulisIndex;
        const shouldHighlight = isSelected || isActive;
        const meta = row.querySelector('[data-penulis-meta]');

        row.dataset.selected = isSelected ? 'true' : 'false';
        row.setAttribute('aria-selected', shouldHighlight ? 'true' : 'false');
        row.classList.toggle('bg-blue-600', shouldHighlight);
        row.classList.toggle('text-white', shouldHighlight);
        row.classList.toggle('bg-white', !shouldHighlight);
        row.classList.toggle('text-slate-900', !shouldHighlight);
        row.classList.toggle('hover:bg-blue-600', !shouldHighlight);
        row.classList.toggle('hover:text-white', !shouldHighlight);

        if (meta) {
            meta.classList.toggle('text-blue-100', shouldHighlight);
            meta.classList.toggle('text-slate-500', !shouldHighlight);
        }

        if (isActive) activeOptionId = row.id;
    });

    if (penulisInput) {
        if (activeOptionId) penulisInput.setAttribute('aria-activedescendant', activeOptionId);
        else penulisInput.removeAttribute('aria-activedescendant');
    }
}

function runPenulisAction(index) {
    const action = penulisActions[index];
    if (!action || !penulisInput) return;

    if (action.type === 'existing') {
        penulisInput.value = action.penulis.nama;
    } else if (action.type === 'new') {
        penulisInput.value = action.name;
    }

    selectedPenulisAction = action;
    setPenulisTypeState(action);
    activePenulisIndex = index;
    refreshPenulisActiveRow();
}

function addPenulisSuggestionRow(action) {
    if (!penulisSuggestions) return;

    const index = penulisActions.push(action) - 1;
    const row = document.createElement('button');
    row.type = 'button';
    row.id = 'penulis_option_' + index;
    row.className = 'group flex w-full cursor-pointer items-center justify-between gap-3 px-3 py-2 text-left text-sm text-slate-900 transition-colors duration-100 hover:bg-blue-600 hover:text-white';
    row.setAttribute('role', 'option');
    row.dataset.actionIndex = String(index);

    row.dataset.selected = isPenulisActionSelected(action) ? 'true' : 'false';

    const label = document.createElement('span');
    label.className = 'min-w-0 flex-1 truncate';

    const meta = document.createElement('span');
    meta.className = 'shrink-0 text-xs text-slate-500 group-hover:text-blue-100';
    meta.dataset.penulisMeta = 'true';

    if (action.type === 'existing') {
        label.innerText = action.penulis.nama;
        meta.innerText = action.penulis.tipe || 'Penulis';
    } else {
        label.innerText = action.name;
        meta.innerText = 'Baru';
    }

    row.appendChild(label);
    row.appendChild(meta);

    row.addEventListener('mousedown', function(e) {
        e.preventDefault();
    });

    row.addEventListener('click', function() {
        runPenulisAction(index);
    });

    penulisSuggestions.appendChild(row);
}

function renderPenulisSuggestions(query) {
    if (!penulisSuggestions) return;

    const rawQuery = (query || '').trim();
    const q = normalizePenulisName(rawQuery);
    if (q.length < MIN_PENULIS_QUERY_LENGTH) {
        clearPenulisSuggestions();
        return;
    }

    const items = ALL_PENULIS
        .filter(p => normalizePenulisName(p.nama).includes(q))
        .slice(0, 10);

    penulisSuggestions.innerHTML = '';
    penulisActions = [];
    activePenulisIndex = -1;

    items.forEach(item => {
        addPenulisSuggestionRow({
            type: 'existing',
            penulis: item
        });
    });

    if (q && !findExactPenulis(rawQuery)) {
        addPenulisSuggestionRow({
            type: 'new',
            name: rawQuery
        });
    }

    if (!penulisActions.length) {
        clearPenulisSuggestions();
        return;
    }

    penulisSuggestions.classList.remove('hidden');
    setPenulisSuggestionsOpen(true);
    refreshPenulisActiveRow();
}

function clearPenulisSuggestions() {
    if (!penulisSuggestions) return;
    penulisSuggestions.innerHTML = '';
    penulisSuggestions.classList.add('hidden');
    penulisActions = [];
    activePenulisIndex = -1;
    setPenulisSuggestionsOpen(false);
}

function addExistingAuthor(penulis) {
    if (!penulis) return;
    if (hasExistingAuthor(penulis.id)) {
        closePenulisModal();
        return;
    }

    addAuthorChip(penulis.id, penulis.nama, penulis.tipe);
    closePenulisModal();
}

function addNewAuthor(name, tipe = 'Nama Orang') {
    const cleanName = (name || '').trim();
    if (!cleanName) return;
    if (hasNewAuthor(cleanName)) {
        closePenulisModal();
        return;
    }

    const existing = findExactPenulis(cleanName);
    if (existing) {
        addExistingAuthor(existing);
        return;
    }

    removeAuthorPlaceholder();

    const wrapper = document.createElement('div');
    wrapper.className = 'author-chip flex items-center justify-between gap-3 px-3 py-3';
    wrapper.dataset.name = normalizePenulisName(cleanName);

    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'penulis_baru[]';
    hidden.value = cleanName;

    const hiddenType = document.createElement('input');
    hiddenType.type = 'hidden';
    hiddenType.name = 'penulis_baru_tipe[]';
    hiddenType.value = tipe || 'Nama Orang';

    const label = document.createElement('span');
    label.className = 'min-w-0 text-sm text-slate-900';
    label.innerText = cleanName + ' ';

    const meta = document.createElement('small');
    meta.className = 'text-slate-500';
    meta.innerText = '(' + (tipe || 'Nama Orang') + ')';
    label.appendChild(meta);

    const btn = createRemoveAuthorButton();

    wrapper.appendChild(hidden);
    wrapper.appendChild(hiddenType);
    wrapper.appendChild(label);
    wrapper.appendChild(btn);
    selectedAuthorsContainer.appendChild(wrapper);

    closePenulisModal();
}

function addPenulisFromInput(showAlert = true) {
    const name = penulisInput ? penulisInput.value.trim() : '';
    if (!name) {
        if (showAlert) alert('Masukkan nama penulis atau pilih dari daftar');
        return;
    }

    if (selectedActionMatchesInput()) {
        if (selectedPenulisAction.type === 'existing') {
            addExistingAuthor(selectedPenulisAction.penulis);
        } else {
            addNewAuthor(selectedPenulisAction.name, getPenulisTypeValue());
        }
        return;
    }

    const existing = findExactPenulis(name);
    if (existing) addExistingAuthor(existing);
    else addNewAuthor(name, getPenulisTypeValue());
}

if (penulisModalOpenBtn) {
    penulisModalOpenBtn.addEventListener('click', openPenulisModal);
}

[penulisModalCloseBtn, penulisModalCancelBtn].forEach(button => {
    if (button) button.addEventListener('click', closePenulisModal);
});

if (addPenulisBtn) {
    addPenulisBtn.addEventListener('click', function() {
        addPenulisFromInput();
    });
}

if (penulisInput) {
    penulisInput.addEventListener('input', function(e) {
        selectedPenulisAction = null;
        setPenulisTypeState(null);

        const q = this.value || '';
        if (!q.trim()) {
            clearPenulisSuggestions();
            return;
        }
        renderPenulisSuggestions(q);
    });

    penulisInput.addEventListener('focus', function() {
        if (this.value.trim()) renderPenulisSuggestions(this.value);
        else clearPenulisSuggestions();
    });

    penulisInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (activePenulisIndex >= 0 && !selectedActionMatchesInput()) runPenulisAction(activePenulisIndex);
            else addPenulisFromInput();
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!penulisActions.length && this.value.trim()) renderPenulisSuggestions(this.value);
            if (!penulisActions.length) return;
            activePenulisIndex = (activePenulisIndex + 1) % penulisActions.length;
            refreshPenulisActiveRow();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (!penulisActions.length) return;
            activePenulisIndex = activePenulisIndex <= 0
                ? penulisActions.length - 1
                : activePenulisIndex - 1;
            refreshPenulisActiveRow();
        } else if (e.key === 'Escape') {
            if (penulisActions.length) clearPenulisSuggestions();
            else closePenulisModal();
        }
    });

    const form = penulisInput.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            if (isPenulisModalOpen()) addPenulisFromInput(false);
        });
    }
}

document.addEventListener('click', function(e) {
    if (
        penulisInput &&
        penulisSuggestions &&
        !penulisInput.contains(e.target) &&
        !penulisSuggestions.contains(e.target)
    ) {
        clearPenulisSuggestions();
    }
});

if (penulisSuggestions) {
    penulisSuggestions.addEventListener('mouseleave', function() {
        activePenulisIndex = -1;
        refreshPenulisActiveRow();
    });
}

if (penulisModal) {
    penulisModal.addEventListener('mousedown', function(e) {
        if (e.target === penulisModal) closePenulisModal();
    });
}

// expose addAuthorChip for reuse
function addAuthorChip(id, name, tipe) {
    if (!id) return;
    if (hasExistingAuthor(id)) return;

    removeAuthorPlaceholder();

    const wrapper = document.createElement('div');
    wrapper.className = 'author-chip flex items-center justify-between gap-3 px-3 py-3';
    wrapper.setAttribute('data-id', id);

    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'id_penulis[]';
    hidden.value = id;

    const label = document.createElement('span');
    label.className = 'min-w-0 text-sm text-slate-900';
    label.innerText = name + ' ';

    const meta = document.createElement('small');
    meta.className = 'text-slate-500';
    meta.innerText = '(' + (tipe || '-') + ')';
    label.appendChild(meta);

    const btn = createRemoveAuthorButton();

    wrapper.appendChild(hidden);
    wrapper.appendChild(label);
    wrapper.appendChild(btn);

    if (selectedAuthorsContainer) selectedAuthorsContainer.appendChild(wrapper);
}


// delegate remove clicks for any prepopulated remove buttons
if (selectedAuthorsContainer) {
    selectedAuthorsContainer.addEventListener('click', function(e) {
        const removeButton = e.target.closest('.remove-author');
        if (removeButton) {
            const chip = removeButton.closest('.author-chip');
            if (chip) chip.remove();
            renderAuthorPlaceholderIfEmpty();
        }
    });
}

// 🔹 Subjek dropdown with checkboxes + visual chips
const subjekDropdownBtn = document.getElementById('subjek_dropdown_btn');
const subjekDropdownMenu = document.getElementById('subjek_dropdown_menu');
const subjekClearOption = document.getElementById('subjek_clear_option');
const subjekHiddenInputs = document.getElementById('subjek_hidden_inputs');
const selectedSubjekContainer = document.getElementById('selected-subjek');

function updateSubjekState() {
    if (!subjekHiddenInputs || !selectedSubjekContainer) return;

    const checkboxes = Array.from(document.querySelectorAll('.subjek-checkbox'));
    const selected = checkboxes.filter(cb => cb.checked).map(cb => {
        const opt = cb.closest('.subjek-option');
        const label = opt ? (opt.querySelector('span') ? opt.querySelector('span').innerText.trim() : '') : '';
        return { id: cb.value, text: label };
    });

    // rebuild hidden inputs for form submission
    subjekHiddenInputs.innerHTML = '';
    selected.forEach(s => {
        const inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = 'id_subjek[]';
        inp.value = s.id;
        subjekHiddenInputs.appendChild(inp);
    });

    // render chips
    selectedSubjekContainer.innerHTML = '';
    if (!selected.length) {
        const p = document.createElement('p');
        p.className = 'text-sm text-gray-500';
        p.innerText = 'Belum ada subjek dipilih.';
        selectedSubjekContainer.appendChild(p);
    } else {
        selected.forEach(s => {
            const wrapper = document.createElement('div');
            wrapper.className = 'subjek-chip flex items-center justify-between gap-2 my-1';
            wrapper.setAttribute('data-id', s.id);

            const label = document.createElement('span');
            label.className = 'text-sm';
            label.innerText = s.text;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'text-red-600 ml-2 remove-subjek';
            btn.innerText = 'Hapus';
            btn.addEventListener('click', function() {
                const cb = Array.from(document.querySelectorAll('.subjek-checkbox')).find(x => x.value === s.id);
                if (cb) {
                    cb.checked = false;
                }
                updateSubjekState();
            });

            wrapper.appendChild(label);
            wrapper.appendChild(btn);
            selectedSubjekContainer.appendChild(wrapper);
        });
    }

    // update selected option highlight
    document.querySelectorAll('.subjek-option').forEach(opt => {
        const cb = opt.querySelector('.subjek-checkbox');
        if (!cb) return;

        opt.classList.toggle('bg-blue-600', cb.checked);
        opt.classList.toggle('text-white', cb.checked);
        opt.classList.toggle('bg-white', !cb.checked);
        opt.classList.toggle('text-slate-900', !cb.checked);
        opt.setAttribute('aria-selected', cb.checked ? 'true' : 'false');
    });

    // update dropdown label
    const labelEl = document.getElementById('subjek_dropdown_label');
    if (labelEl) {
        if (selected.length === 0) labelEl.innerText = 'Pilih Subjek';
        else if (selected.length === 1) labelEl.innerText = selected[0].text;
        else labelEl.innerText = selected.map(s => s.text).join(', ');
    }
}

// toggle menu and outside click handling
if (subjekDropdownBtn && subjekDropdownMenu) {
    subjekDropdownBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        subjekDropdownMenu.classList.toggle('hidden');
        const expanded = subjekDropdownBtn.getAttribute('aria-expanded') === 'true';
        subjekDropdownBtn.setAttribute('aria-expanded', (!expanded).toString());
    });

    document.addEventListener('click', function(e) {
        if (!subjekDropdownMenu.contains(e.target) && !subjekDropdownBtn.contains(e.target)) {
            subjekDropdownMenu.classList.add('hidden');
            subjekDropdownBtn.setAttribute('aria-expanded', 'false');
        }
    });
}

// wire change listeners for checkboxes
document.querySelectorAll('.subjek-checkbox').forEach(cb => cb.addEventListener('change', updateSubjekState));

if (subjekClearOption) {
    subjekClearOption.addEventListener('click', function(e) {
        e.stopPropagation();
        document.querySelectorAll('.subjek-checkbox').forEach(cb => {
            cb.checked = false;
        });
        updateSubjekState();
    });
}

// initialize on load
updateSubjekState();
