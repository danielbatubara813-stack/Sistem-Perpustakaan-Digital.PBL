{{-- Halaman Pengembalian (Admin) --}}
@extends('layout.app-admin')

@section('title', 'Pengembalian')
@php
    $title = 'Pengembalian';
    $description = 'Kelola pengembalian buku dan catat pengembalian baru.';
@endphp
@section('content')
    <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <div class="bg-slate-100 rounded-md px-2 py-1 flex items-center gap-2">
                <a href="#" class="px-4 py-2 text-sm text-slate-600">Peminjaman</a>
                <a href="#" class="px-4 py-2 text-sm bg-blue-600 text-white shadow rounded">Pengembalian</a>
            </div>

            <div>
                <a href="#"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm shadow transition">
                    Catat Pengembalian
                </a>
            </div>
        </div>

        <div class="overflow-x-auto mt-2">
            <p class="text-sm text-slate-500">Halaman pengembalian masih kosong (placeholder).</p>
        </div>
    </div>
@endsection
