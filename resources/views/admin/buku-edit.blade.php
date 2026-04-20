@extends('layout.app-admin')

@section('content')
    <div class="p-6 poppins">
        <div class="mb-4 flex items-center justify-between bg-white rounded-lg p-4">
            <h1 class="font-bold text-3xl">Edit Buku</h1>
        </div>

        <div class="bg-white p-6 rounded-lg mt-4 shadow-lg">
            <p class="text-sm text-slate-500">Edit buku ID: {{ $id }}</p>
            <a href="{{ route('admin.buku') }}" class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white rounded-md px-3 py-2 text-sm">Kembali</a>
        </div>
    </div>
@endsection
