{{-- Halaman Pengembalian (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Pengembalian')
@php
    $title = 'Pengembalian';
    $description = 'Kelola pengembalian buku dan catat pengembalian baru.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        {{-- Tabs --}}
        <div class="mb-4">
            <div class="bg-slate-100 rounded-md px-2 py-1 inline-flex items-center gap-2">
                <button data-tab="list" class="tab-btn px-4 py-2 text-sm text-slate-600">Daftar Pengembalian</button>
                <button data-tab="return" class="tab-btn px-4 py-2 text-sm bg-blue-600 text-white shadow rounded">Pengembalian Buku</button>
                <button data-tab="quick" class="tab-btn px-4 py-2 text-sm text-slate-600">Pengembalian Buku Cepat</button>
            </div>
        </div>

        <div id="tab-content">
            @include('admin.pengembalian.buku')
            @include('admin.pengembalian.daftar')
            @include('admin.pengembalian.cepat')
        </div>

        <script>
            (function(){
                const tabs = document.querySelectorAll('.tab-btn');
                const panels = document.querySelectorAll('.tab-panel');
                function setActive(tabName){
                    tabs.forEach(b=>{
                        if(b.dataset.tab===tabName){
                            b.classList.remove('text-slate-600');
                            b.classList.add('bg-blue-600','text-white','shadow','rounded');
                        } else {
                            b.classList.remove('bg-blue-600','text-white','shadow','rounded');
                            b.classList.add('text-slate-600');
                        }
                    });
                    panels.forEach(p=>p.classList.add('hidden'));
                    const active = document.getElementById('tab-'+tabName);
                    if(active) active.classList.remove('hidden');
                }
                tabs.forEach(b=>b.addEventListener('click', ()=> setActive(b.dataset.tab)));
                // default to return tab
                setActive('return');
            })();
        </script>
    </div>
@endsection
