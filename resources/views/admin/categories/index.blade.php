@extends('layouts.admin')

@section('page_title', 'Manajemen Kategori')
@section('page_subtitle', 'Kelola data kategori event')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
    <div class="flex flex-col md:flex-row gap-4 justify-between">

        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-2 w-full md:w-1/2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari kategori..."
                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700">Cari</button>
            @if($search)
                <a href="{{ route('admin.categories.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-300">Reset</a>
            @endif
        </form>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-2 w-full md:w-1/2">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori baru..." required
                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-green-700 whitespace-nowrap">+ Tambah</button>
        </form>

    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th class="text-left px-6 py-4 font-bold text-slate-500">ID</th>
                <th class="text-left px-6 py-4 font-bold text-slate-500">Nama</th>
                <th class="text-left px-6 py-4 font-bold text-slate-500">Created At</th>
                <th class="text-left px-6 py-4 font-bold text-slate-500">Updated At</th>
                <th class="text-left px-6 py-4 font-bold text-slate-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $category)
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 text-slate-400">{{ $category->id }}</td>
                <td class="px-6 py-4 font-semibold">{{ $category->name }}</td>
                <td class="px-6 py-4 text-slate-400">{{ $category->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-slate-400">{{ $category->updated_at->format('d M Y') }}</td>
                <td class="px-6 py-4 flex gap-2">
                    <button onclick="document.getElementById('editModal{{ $category->id }}').classList.remove('hidden')"
                        class="bg-yellow-400 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-yellow-500">Edit</button>

                    <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}"
                        onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-600">Hapus</button>
                    </form>
                </td>
            </tr>

            <div id="editModal{{ $category->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
                    <h3 class="text-lg font-bold mb-4">Edit Kategori</h3>
                    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ $category->name }}" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <div class="flex gap-2 justify-end">
                            <button type="button"
                                onclick="document.getElementById('editModal{{ $category->id }}').classList.add('hidden')"
                                class="bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold">Batal</button>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-slate-400">Tidak ada data kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection