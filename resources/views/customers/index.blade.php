<x-app-layout>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Hilangkan elemen bawaan yang jelek */
        table.dataTable.no-footer { border-bottom: 1px solid #e5e7eb; }
        
        /* Wrapper DataTables */
        .dataTables_wrapper { padding: 0; font-family: 'Inter', sans-serif; }
        
        /* Input Search & Select agar mirip Tailwind */
        .dataTables_wrapper .dataTables_length select {
            padding: 0.25rem 2rem 0.25rem 0.75rem;
            border-radius: 0.5rem;
            border-color: #d1d5db;
            color: #374151;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.4rem 0.8rem;
            margin-left: 0.5rem;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
            margin-bottom: 1rem;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Paginasi yang lebih cantik */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem !important;
            border: 1px solid transparent !important;
            padding: 0.3em 0.8em !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4f46e5 !important; /* Indigo-600 */
            color: white !important;
            border: 1px solid #4f46e5 !important;
            font-weight: bold;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e0e7ff !important; /* Indigo-100 */
            color: #374151 !important;
            border: 1px solid #c7d2fe !important;
        }
    </style>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Manajemen Pelanggan') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data pemilik kendaraan dan riwayat kontak.</p>
            </div>
            
            <a href="{{ route('customers.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pelanggan
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                    <span class="sr-only">Info</span>
                    <div class="font-medium">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center p-4 mb-6 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                    <div class="font-medium">Error: {{ session('error') }}</div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    <table id="customerTable" class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Nama Pelanggan</th>
                                <th class="px-6 py-4">No. Telepon</th>
                                <th class="px-6 py-4">Alamat Domisili</th>
                                <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="bg-white border-b hover:bg-indigo-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                                    {{ strtoupper(substr($customer->nama_pelanggan, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ $customer->nama_pelanggan }}</div>
                                                {{-- <div class="text-gray-500 text-xs">ID: #{{ $customer->id }}</div> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($customer->no_telepon)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200">
                                                {{ $customer->no_telepon }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ Str::limit($customer->alamat, 45) ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="group relative" title="Edit Data">
                                                <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600 hover:bg-yellow-200 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </div>
                                            </a>

                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan {{ $customer->nama_pelanggan }} beserta seluruh data motornya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="group relative p-2 bg-red-100 rounded-lg text-red-600 hover:bg-red-200 transition" title="Hapus Data">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                },
                responsive: true,
                autoWidth: false,
                // Matikan sorting untuk kolom Aksi (indeks 3)
                columnDefs: [ { orderable: false, targets: 3 } ],
                // Menghilangkan pesan 'Processing' default
                processing: true,
            });
        });
    </script>
</x-app-layout>