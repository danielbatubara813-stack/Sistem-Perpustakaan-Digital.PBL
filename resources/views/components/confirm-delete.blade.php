<div id="delete-confirmation" class="fixed top-0 left-0 w-full h-screen bg-black/50 backdrop-blur-md z-30 hidden">
    <div class="w-full h-full flex items-center justify-center">
        <div class="w-max bg-white p-4 rounded-lg shadow-lg flex items-center justify-center flex-col relative">
            <button id="close-delete-modal"
                class="absolute top-0 right-0 m-4 text-black hover:bg-gray-200 p-1 rounded-md transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
            <div class="p-4 rounded-full bg-red-600 text-white font-bold w-24 h-24 aspect-square mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </div>
            <h4 class="font-bold text-2xl capitalize">Hapus Data!</h4>
            <p class="w-3/4 text-sm text-center">Anda akan menghapus data ini, Apakah anda yakin untuk menghapus data
                ini?</p>

            <div class="mt-8 space-x-4 text-sm flex">
                <button id="cancel-delete"
                    class="w-56 font-medium px-6 py-2 rounded-md bg-gray-200 hover:bg-gray-300 transition-all duration-300 ease-in-out">Tidak,
                    Tetap
                    Simpan</button>
                <button id="confirm-delete"
                    class="w-56 text-white font-medium px-6 py-2 rounded-md bg-red-600 hover:bg-red-700 transition-all duration-300 ease-in-out">Ya,
                    Hapus
                    Data</button>
            </div>
        </div>
    </div>
</div>
