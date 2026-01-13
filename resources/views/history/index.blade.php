<x-app-layout>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        /* Styling Dasar Tabel */
        table.dataTable.no-footer { border-bottom: 1px solid #e5e7eb; }
        .dataTables_wrapper { padding: 0; font-family: 'Inter', sans-serif; }
        
        /* Matikan Pointer & Icon Sorting pada Header Kolom */
        table.dataTable thead th {
            pointer-events: none; /* User tidak bisa klik header */
            background-image: none !important; /* Hilangkan panah sort */
            cursor: default !important;
        }

        /* Styling Input Search & Length */
        .dataTables_wrapper .dataTables_length select {
            padding: 0.25rem 2rem 0.25rem 0.75rem;
            border-radius: 0.5rem;
            border-color: #d1d5db;
            margin-bottom: 1rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.4rem 0.8rem;
            margin-left: 0.5rem;
            outline: none;
            margin-bottom: 1rem;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Tombol Export */
        .dt-buttons .dt-button {
            background: white !important;
            color: #374151 !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            padding: 0.4rem 0.8rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin-right: 0.5rem !important;
            transition: all 0.2s !important;
        }
        .dt-buttons .dt-button:hover {
            background: #f3f4f6 !important;
        }
        .buttons-pdf { border-bottom: 2px solid #ef4444 !important; }
        .buttons-excel { border-bottom: 2px solid #10b981 !important; }

        /* Paginasi */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4f46e5 !important;
            color: white !important;
            border: 1px solid #4f46e5 !important;
            font-weight: bold;
        }
    </style>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Riwayat Diagnosa') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Laporan lengkap hasil prediksi AI dan rekomendasi perawatan.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                        <div class="flex items-center">
                            <label for="customSort" class="mr-2 text-sm font-bold text-gray-700">Urutkan Waktu:</label>
                            <select id="customSort" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="desc" selected>📅 Paling Baru (Teratas)</option>
                                <option value="asc">⏳ Paling Lama (Teratas)</option>
                            </select>
                        </div>
                        
                        <div id="buttonsContainer"></div>
                    </div>

                    <table id="historyTable" class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Waktu</th>
                                <th class="px-6 py-4">Kendaraan</th>
                                <th class="px-6 py-4">Gejala Dilaporkan</th>
                                <th class="px-6 py-4">Hasil Diagnosa</th>
                                <th class="px-6 py-4 rounded-tr-lg">Rekomendasi Utama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                                <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                                    {{-- 
                                        PENTING: Atribut data-sort="{{ $history->created_at }}"
                                        Ini agar DataTables mengurutkan berdasarkan Waktu Asli (Timestamp),
                                        bukan berdasarkan teks "12 Jan 2025" (karena secara abjad 12 Jan kalah dgn 20 Feb).
                                    --}}
                                    <td class="px-6 py-4 whitespace-nowrap" data-sort="{{ $history->created_at }}">
                                        <div class="font-medium text-gray-900">
                                            {{ $history->created_at->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $history->created_at->format('H:i') }} WIB
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="ml-0">
                                                <div class="font-bold text-gray-900">
                                                    {{ $history->vehicle->no_polisi ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $history->vehicle->customer->nama_pelanggan ?? 'Tanpa Pemilik' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <span class="bg-yellow-50 text-yellow-700 px-2 py-1 rounded text-xs border border-yellow-200">
                                            {{ Str::limit($history->input_gejala, 40) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $history->hasil_kelas_prediksi }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        @if(!empty($history->hasil_rekomendasi_copras[0]['nama']))
                                            {{ $history->hasil_rekomendasi_copras[0]['nama'] }}
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
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
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#historyTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
                responsive: true,
                autoWidth: false,
                
                // Set Default: Kolom 0 (Waktu) Descending (Terbaru)
                order: [[ 0, "desc" ]], 

                // MATIKAN KLIK SORTING PADA SEMUA KOLOM
                // Kita akan kontrol sorting lewat dropdown saja
                columnDefs: [
                    { orderable: true, targets: 0 }, // Kolom Waktu harus true agar API bisa sorting
                    { orderable: false, targets: [1, 2, 3, 4] } // Kolom lain matikan total
                ],

                // Konfigurasi Export
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '📄 Excel',
                        className: 'buttons-excel',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📕 PDF',
                        className: 'buttons-pdf',
                        orientation: 'landscape',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    },
                    {
                        extend: 'print',
                        text: '🖨️ Print',
                        exportOptions: { columns: [0, 1, 2, 3, 4] }
                    }
                ]
            });

            // LOGIKA CUSTOM SORTING (Dropdown)
            $('#customSort').on('change', function() {
                var direction = $(this).val(); // 'asc' atau 'desc'
                // Perintahkan DataTables untuk sort kolom index 0 (Waktu)
                table.order([0, direction]).draw();
            });

            // Styling: Pindahkan tombol Export ke div custom kita agar rapi
            table.buttons().container().appendTo('#buttonsContainer');
        });
    </script>
</x-app-layout>