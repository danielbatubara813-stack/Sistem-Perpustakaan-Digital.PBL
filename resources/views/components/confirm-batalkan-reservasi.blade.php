<div id="cancel-reservation-modal" class="fixed inset-0 bg-black/50 backdrop-blur-md z-50 hidden p-4">

    <div class="w-full h-full flex items-center justify-center">

        <div
            class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg flex items-center justify-center flex-col relative">

            <button id="close-cancel-modal"
                class="absolute top-0 right-0 m-4 text-black hover:bg-gray-200 p-1 rounded-md transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>

            <div
                class="p-4 rounded-full bg-amber-500 text-white w-20 h-20 lg:w-24 lg:h-24 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                    <path
                        d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                </svg>
            </div>

            <h4 class="font-bold text-xl lg:text-2xl text-center">
                Batalkan Reservasi?
            </h4>

            <p class="text-sm text-center mt-3 text-gray-600">
                Reservasi yang dibatalkan tidak dapat diproses kembali.
                Apakah Anda yakin ingin membatalkan reservasi ini?
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 w-full">

                <button id="cancel-reservation-action"
                    class="cursor-pointer w-full font-medium px-6 py-3 rounded-md bg-gray-200 hover:bg-gray-300 transition-all duration-300">
                    Tidak, Kembali
                </button>

                <button id="confirm-cancel-reservation"
                    class="cursor-pointer w-full text-white font-medium px-6 py-3 rounded-md bg-amber-500 hover:bg-amber-600 transition-all duration-300">
                    Ya, Batalkan
                </button>

            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const modal = document.getElementById('cancel-reservation-modal');
        let activeForm = null;

        document.querySelectorAll('.open-cancel-modal').forEach(button => {
            button.addEventListener('click', function(e) {

                e.preventDefault();
                e.stopPropagation();

                activeForm = this.closest('form');

                // Jika ada data-action dan hidden action
                if (activeForm) {
                    const actionInput = activeForm.querySelector(
                        'input[name="action"]'
                    );

                    if (actionInput && this.dataset.action) {
                        actionInput.value = this.dataset.action;
                    }
                }

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });

        document.getElementById('close-cancel-modal').addEventListener('click', closeModal);
        document.getElementById('cancel-reservation-action').addEventListener('click', closeModal);

        document.getElementById('confirm-cancel-reservation').addEventListener('click', function() {

            if (activeForm) {
                activeForm.submit();
            }

            closeModal();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        function closeModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

    });
</script>
