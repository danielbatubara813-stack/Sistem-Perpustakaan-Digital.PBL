{{-- Universal Notification --}}
<div id="notification" class="fixed top-0 right-0 z-50 m-4 translate-y-[-200%] opacity-0 transition-all duration-500">

    <div id="notification-wrapper" class="flex items-center gap-3 px-4 py-3 shadow-sm border-l-2 rounded-md">

        {{-- Icon --}}
        <div id="notification-icon-wrapper" class="p-3 rounded-md">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path id="notification-icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />

            </svg>

        </div>



        {{-- Content --}}
        <div class="w-72">

            <h6 id="notification-title" class="font-bold">
            </h6>

            <span id="notification-message" class="text-sm">
            </span>

        </div>



        {{-- Close --}}
        <button type="button" onclick="closeNotification()">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />

            </svg>

        </button>

    </div>
</div>
<script>
    // =========================
    // SHOW NOTIFICATION
    // =========================

    function showNotification(
        type,
        message
    ) {

        const notification =
            document.getElementById(
                'notification'
            );

        const wrapper =
            document.getElementById(
                'notification-wrapper'
            );

        const iconWrapper =
            document.getElementById(
                'notification-icon-wrapper'
            );

        const iconPath =
            document.getElementById(
                'notification-icon-path'
            );

        const title =
            document.getElementById(
                'notification-title'
            );

        const text =
            document.getElementById(
                'notification-message'
            );



        // reset class
        wrapper.className =
            'flex items-center gap-3 px-4 py-3 shadow-sm border-l-2 rounded-md';

        iconWrapper.className =
            'p-3 rounded-md';



        // =========================
        // SUCCESS
        // =========================

        if (type === 'success') {

            wrapper.classList.add(
                'bg-emerald-50',
                'border-emerald-600',
                'text-emerald-700'
            );

            iconWrapper.classList.add(
                'bg-emerald-200'
            );

            title.innerText =
                'Berhasil!!!';

            iconPath.setAttribute(
                'd',
                'M5 13l4 4L19 7'
            );

        }



        // =========================
        // ERROR
        // =========================
        else if (type === 'error') {

            wrapper.classList.add(
                'bg-red-50',
                'border-red-600',
                'text-red-700'
            );

            iconWrapper.classList.add(
                'bg-red-200'
            );

            title.innerText =
                'Gagal!!!';

            iconPath.setAttribute(
                'd',
                'M6 18L18 6M6 6l12 12'
            );

        }



        // =========================
        // WARNING
        // =========================
        else if (type === 'warning') {

            wrapper.classList.add(
                'bg-yellow-50',
                'border-yellow-500',
                'text-yellow-700'
            );

            iconWrapper.classList.add(
                'bg-yellow-200'
            );

            title.innerText =
                'Peringatan!!!';

            iconPath.setAttribute(
                'd',
                'M12 9v4m0 4h.01'
            );

        }



        // =========================
        // INFO
        // =========================
        else if (type === 'info') {

            wrapper.classList.add(
                'bg-blue-50',
                'border-blue-600',
                'text-blue-700'
            );

            iconWrapper.classList.add(
                'bg-blue-200'
            );

            title.innerText =
                'Informasi';

            iconPath.setAttribute(
                'd',
                'M13 16h-1v-4h-1m1-4h.01'
            );

        }



        // set message
        text.innerText =
            message;



        // show
        notification.classList.remove(
            'translate-y-[-200%]',
            'opacity-0'
        );

        notification.classList.add(
            'translate-y-0',
            'opacity-100'
        );



        // auto close
        setTimeout(() => {

            closeNotification();

        }, 3000);

    }



    // =========================
    // CLOSE NOTIFICATION
    // =========================

    function closeNotification() {

        const notification =
            document.getElementById(
                'notification'
            );

        notification.classList.remove(
            'translate-y-0',
            'opacity-100'
        );

        notification.classList.add(
            'translate-y-[-200%]',
            'opacity-0'
        );

    }



    // =========================
    // SESSION FROM LARAVEL
    // =========================

    window.addEventListener(
        'load',
        () => {

            @if (session('success'))

                setTimeout(() => {

                    showNotification(
                        'success',
                        "{{ session('success') }}"
                    );

                }, 200);
            @endif



            @if (session('error'))

                setTimeout(() => {

                    showNotification(
                        'error',
                        "{{ session('error') }}"
                    );

                }, 200);
            @endif



            @if (session('warning'))

                setTimeout(() => {

                    showNotification(
                        'warning',
                        "{{ session('warning') }}"
                    );

                }, 200);
            @endif



            @if (session('info'))

                setTimeout(() => {

                    showNotification(
                        'info',
                        "{{ session('info') }}"
                    );

                }, 200);
            @endif

        }
    );
</script>
