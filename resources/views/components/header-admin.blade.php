 <div class="bg-white rounded-lg p-4 mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
     <div>
         <h1 class="text-2xl font-bold uppercase tracking-wide">{{ $title }}</h1>
         <p class="text-xs md:text-sm text-gray-500 mt-1">{{ $description }}</p>
     </div>
     <div class="hidden lg:flex items-center gap-3">
         <div class="text-right">
             <p class="font-medium">{{ Auth::user()->username }}</p>
             <p class="text-xs text-gray-500">Pengelola Perpus</p>
         </div>
         <img class="rounded-full w-10 h-10 object-cover" src="{{ asset('images/default-avatar.svg') }}" alt="Avatar Admin">
     </div>
 </div>
