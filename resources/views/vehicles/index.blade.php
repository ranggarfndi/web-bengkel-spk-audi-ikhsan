<x-app-layout>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable.no-footer { border-bottom: 1px solid #e5e7eb; }
        .dataTables_wrapper { padding: 0; font-family: 'Inter', sans-serif; }
        
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
            border-color: #6366f1; /* Indigo-500 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem !important;
            border: 1px solid transparent !important;
            padding: 0.3em 0.8em !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4f46e5 !important;
            color: white !important;
            border: 1px solid #4f46e5 !important;
            font-weight: bold;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e0e7ff !important;
            color: #374151 !important;
            border: 1px solid #c7d2fe !important;
        }
    </style>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Manajemen Kendaraan') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftar kendaraan pelanggan yang terdaftar di bengkel.</p>
            </div>
            
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kendaraan
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
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
                    
                    <table id="vehicleTable" class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Info Kendaraan</th>
                                <th class="px-6 py-4">Pemilik</th>
                                <th class="px-6 py-4">Tahun</th>
                                <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicles as $vehicle)
                                <tr class="bg-white border-b hover:bg-blue-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-gray-900 text-base">{{ $vehicle->no_polisi }}</div>
                                                <div class="text-gray-500 text-xs uppercase tracking-wide">
                                                    {{ $vehicle->merek_motor }} - {{ $vehicle->tipe_motor }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($vehicle->customer)
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="font-medium text-gray-700">
                                                    {{ $vehicle->customer->nama_pelanggan }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-red-400 italic text-xs">Tanpa Pemilik</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2.5 py-1 rounded border border-gray-200">
                                            {{ $vehicle->tahun_pembuatan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="group relative" title="Edit Data">
                                                <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600 hover:bg-yellow-200 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </div>
                                            </a>

                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Hapus kendaraan {{ $vehicle->no_polisi }}?');">
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
            $('#vehicleTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                },
                responsive: true,
                autoWidth: false,
                columnDefs: [ { orderable: false, targets: 3 } ], // Kolom Aksi tidak bisa disort
                processing: true,
            });
        });
    </script>
</x-app-layout>