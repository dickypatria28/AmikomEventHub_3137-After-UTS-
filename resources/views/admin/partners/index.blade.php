@extends('layouts.admin')

@section('content')
<div class="p-6 sm:p-8 space-y-6">
    {{-- Header Halaman --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Manajemen Partner</h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Kelola data partner pendukung event</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-stretch">

            <form method="GET" action="{{ route('admin.partners.index') }}" class="flex gap-2 w-full lg:w-5/12">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Cari partner..."
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 active:scale-95 transition-all shadow-md shadow-indigo-100">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.partners.index') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all flex items-center">
                        Reset
                    </a>
                @endif
            </form>

            <form method="POST" action="{{ route('admin.partners.store') }}" class="flex flex-col sm:flex-row gap-2 w-full lg:w-7/12">
                @csrf
                <input type="text" name="name" placeholder="Nama partner baru..." required
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <input type="text" name="logo_url" placeholder="URL Logo (https://...)" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <button type="submit" class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-emerald-700 active:scale-95 transition-all whitespace-nowrap shadow-md shadow-emerald-100">
                    + Tambah
                </button>
            </form>

        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 font-bold">
                    <tr>
                        <th class="px-6 py-4 w-20">ID</th>
                        <th class="px-6 py-4 w-40">Logo</th>
                        <th class="px-6 py-4">Nama Partner</th>
                        <th class="px-6 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($partners as $index => $partner)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 text-slate-400 font-medium">{{ $partner->id }}</td>
                        <td class="px-6 py-4">
                            <div class="p-1.5 bg-slate-50 rounded-xl border border-slate-100 inline-block">
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" 
                                     class="h-8 w-20 object-contain"
                                     onerror="this.onerror=null;this.src='https://placehold.co/100x40?text=No+Logo'">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $partner->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="document.getElementById('editPartnerModal{{ $partner->id }}').classList.remove('hidden')"
                                    class="bg-amber-400 text-white px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-amber-500 transition-all shadow-sm active:scale-95">
                                    Edit
                                </button>

                                <form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner {{ $partner->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-500 text-white px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-rose-600 transition-all shadow-sm active:scale-95">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div id="editPartnerModal{{ $partner->id }}" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center z-50 animate-fade-in">
                        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-100 transform scale-100 transition-all">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-slate-800">Edit Partner</h3>
                                <button type="button" onclick="document.getElementById('editPartnerModal{{ $partner->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <form method="POST" action="{{ route('admin.partners.update', $partner->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Partner</label>
                                        <input type="text" name="name" value="{{ $partner->name }}" required
                                            class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">URL Logo Partner</label>
                                        <input type="text" name="logo_url" value="{{ $partner->logo_url }}" required
                                            class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>
                                
                                <div class="flex gap-2 justify-end mt-6">
                                    <button type="button"
                                        onclick="document.getElementById('editPartnerModal{{ $partner->id }}').classList.add('hidden')"
                                        class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">
                                        Batal
                                    </button>
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic bg-slate-50/50">
                            Tidak ada data partner pendukung yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection