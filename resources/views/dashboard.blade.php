<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500 flex items-center justify-between transition hover:shadow-md">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Servis</p>
                        <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalPrediksi }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between transition hover:shadow-md">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Ringan</p>
                        <p class="text-3xl font-black text-gray-800 mt-1">{{ $distribusiKelas['Ringan'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between transition hover:shadow-md">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Sedang</p>
                        <p class="text-3xl font-black text-gray-800 mt-1">{{ $distribusiKelas['Sedang'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 flex items-center justify-between transition hover:shadow-md">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Berat</p>
                        <p class="text-3xl font-black text-gray-800 mt-1">{{ $distribusiKelas['Tinggi'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-full text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 flex flex-col justify-center items-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 self-start">Distribusi Kerusakan</h3>
                    <div class="w-full h-64 relative">
                        <canvas id="chartDistribusi"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Tren Gejala Kerusakan (Top 5)</h3>
                        <span class="text-xs bg-gray-100 text-gray-500 py-1 px-2 rounded">Berdasarkan frekuensi input</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Nama Gejala</th>
                                    <th class="px-4 py-3 text-right">Jumlah</th>
                                    <th class="px-4 py-3 rounded-r-lg text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gejalaPopuler as $index => $gejala)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900 flex items-center">
                                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold mr-3">
                                                {{ $index + 1 }}
                                            </span>
                                            {{ $gejala->input_gejala }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-bold">{{ $gejala->total }} Kasus</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-200 mt-1">
                                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, ($gejala->total / $totalPrediksi) * 100 * 2) }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-400">Belum ada data gejala.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Aktivitas Servis Terbaru</h3>
                    <a href="{{ route('predict.history') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua Riwayat &rarr;</a>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-gray-100">
                        @forelse($servisTerbaru as $history)
                            <li class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">
                                            {{ $history->vehicle->no_polisi }} 
                                            <span class="font-normal text-gray-500">| {{ $history->vehicle->customer->nama_pelanggan ?? 'Umum' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">
                                            Keluhan: {{ Str::limit($history->input_gejala, 50) }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-sm">
                                        @if($history->hasil_kelas_prediksi == 'Ringan')
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Ringan</span>
                                        @elseif($history->hasil_kelas_prediksi == 'Sedang')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Sedang</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Berat</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-400 pl-4 border-l">
                                        {{ $history->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="p-4 text-center text-gray-500">Belum ada aktivitas servis.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chartDistribusi').getContext('2d');
            
            // Data dari Controller Laravel
            const dataRingan = {{ $distribusiKelas['Ringan'] ?? 0 }};
            const dataSedang = {{ $distribusiKelas['Sedang'] ?? 0 }};
            const dataTinggi = {{ $distribusiKelas['Tinggi'] ?? 0 }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Ringan', 'Sedang', 'Berat'],
                    datasets: [{
                        data: [dataRingan, dataSedang, dataTinggi],
                        backgroundColor: [
                            '#10B981', // Green-500
                            '#F59E0B', // Yellow-500
                            '#EF4444'  // Red-500
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>