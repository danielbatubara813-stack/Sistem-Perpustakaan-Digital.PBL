(function () {
    // allow single-delete flow from pages (set window.singleDeleteAction = '<url>')
    window.singleDeleteAction = null;
    const selectAllBtn = document.getElementById('selectAllTopBtn');
    const deleteBtn = document.getElementById('deleteSelected');
    const deleteForm = document.getElementById('multi-delete-form');

    const deleteModal = document.getElementById('delete-confirmation');
    const deleteModalContent = document.getElementById('delete-modal-content');
    const cancelDelete = document.getElementById('cancel-delete');
    const closeDeleteModal = document.getElementById('close-delete-modal');
    const confirmDelete = document.getElementById('confirm-delete');

    // kode yang berfungsi untuk mencentang semua data pada halaman tersebut
    const rowCheckboxes = () =>
        Array.from(document.querySelectorAll('input.row-checkbox'));
    let active = false;

    // kode yang berfungsi untuk mencentang semua data pada halaman tersebut secara visual
    const setSelectAllVisual = (element, state) => {
        if (!element) return;
        const checkedIcon = element.querySelector('.icon-checked');

        const uncheckedIcon = element.querySelector('.icon-unchecked');

        if (checkedIcon) {
            checkedIcon.classList.toggle('hidden', !state);
        }

        if (uncheckedIcon) {
            uncheckedIcon.classList.toggle('hidden', state);
        }

        element.classList.toggle('bg-blue-700', state);
    };



    // Ini berfungsi untuk membuka modal confirm delete
    function openModal() {
        if (!deleteModal) return;
        deleteModal.classList.remove('hidden');

        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');

            if (deleteModalContent) {
                deleteModalContent.classList.remove('opacity-0', 'scale-95');
                deleteModalContent.classList.add('opacity-100', 'scale-100');
            }
        }, 10);
    }

    // expose open/close so other pages can open the modal for single-delete
    window.openDeleteModal = openModal;

    // Ini berfungsi untuk menutup modal confirm delete
    function closeModal() {
        if (!deleteModal) return;
        deleteModal.classList.add('opacity-0');

        if (deleteModalContent) {
            deleteModalContent.classList.remove('opacity-100', 'scale-100');
            deleteModalContent.classList.add('opacity-0', 'scale-95');
        }

        setTimeout(() => {
            deleteModal.classList.add('hidden');
        }, 300);
    }

    window.closeDeleteModal = closeModal;

    // ini berfungsi untuk mentrigger fungsi diatas berupa centang seluruh data pada halaman tersebut
    if (selectAllBtn) {
        selectAllBtn.addEventListener(
            'click',
            function (event) {
                event.preventDefault();
                active = !active;

                rowCheckboxes().forEach(
                    checkbox => {
                        checkbox.checked = active;
                    }
                );

                setSelectAllVisual(this, active);
            }
        );
    }



    // =========================
    // SYNC CHECKBOX
    // =========================

    rowCheckboxes().forEach(
        checkbox => {
            checkbox.addEventListener('change', function () {
                if (!selectAllBtn) return;
                const allCheckboxes = rowCheckboxes();
                const allChecked = allCheckboxes.length && allCheckboxes.every(checkbox => checkbox.checked);

                active = !!allChecked;
                setSelectAllVisual(selectAllBtn, active);
            });
        }
    );

    // ini berfungsi untuk mengaktifkan modal konfirmasi hapus dengan tombol hapus data diseleksi pada tampilan
    if (deleteBtn) {

        deleteBtn.addEventListener('click', function (event) {
            event.preventDefault();

            const checkedRows = rowCheckboxes().filter(checkbox =>
                checkbox.checked
            );

            // validasi untuk mengecek data harus dipilih salah satu
            if (!checkedRows.length) {
                showNotification('warning', 'Pilih minimal satu data');
                return;
            }
            // tampilkan modal
            openModal();

        });
    }

    // ini berfungsi untuk membatalkan delete data pada tombol
    if (cancelDelete) {
        cancelDelete.addEventListener('click', function (event) {
            event.preventDefault();
            closeModal();
        });
    }

    // ini berfungsi untuk menutup modal konfirmasi hapus
    if (closeDeleteModal) {
        closeDeleteModal.addEventListener('click', function (event) {
            event.preventDefault();
            closeModal();
        });
    }

    // ini berfungsi untuk menutup modal konfirmasi hapus
    if (deleteModal) {
        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                closeModal();
            }
        });
    }

    // ini berfungsi untuk mengkonfirmasi penghapusan data dengan tekan tombol iya pada modal
    if (confirmDelete) {
        confirmDelete.addEventListener('click', function (event) {
            event.preventDefault();
            // if a single-delete action was set by a page, prefer that
            if (window.singleDeleteAction) {
                const url = window.singleDeleteAction;
                window.singleDeleteAction = null;

                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                const f = document.createElement('form');
                f.method = 'POST';
                f.action = url;

                const _csrf = document.createElement('input');
                _csrf.type = 'hidden';
                _csrf.name = '_token';
                _csrf.value = csrf;
                f.appendChild(_csrf);

                const _m = document.createElement('input');
                _m.type = 'hidden';
                _m.name = '_method';
                _m.value = 'DELETE';
                f.appendChild(_m);

                document.body.appendChild(f);
                f.submit();
                return;
            }

            const checkedRows = rowCheckboxes().filter(checkbox => checkbox.checked);

            const selectedIds = checkedRows.map(checkbox => checkbox.value);

            // ambil field name
            const deleteFieldName = deleteForm.dataset.deleteName;

            // hapus hidden input lama
            document.querySelectorAll('.multi-delete-hidden-input').forEach(hiddenInput =>
                hiddenInput.remove()
            );

            // append hidden input baru
            selectedIds.forEach(selectedId => {
                const hiddenInput = document.createElement('input');

                hiddenInput.type = 'hidden';
                hiddenInput.name = `${deleteFieldName}[]`;
                hiddenInput.value = selectedId;
                hiddenInput.classList.add('multi-delete-hidden-input');
                deleteForm.appendChild(hiddenInput);
            }
            );
            // submit form
            deleteForm.submit();
        });
    }
})();
