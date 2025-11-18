<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Manajemen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Servis Tercatat</h3>
                        <p class="text-3xl font-semibold">{{ $totalPrediksi }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Servis Ringan</h3>
                        <p class="text-3xl font-semibold">{{ $distribusiKelas['Ringan'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Servis Sedang</h3>
                        <p class="text-3xl font-semibold">{{ $distribusiKelas['Sedang'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Servis Tinggi</h3>
                        <p class="text-3xl font-semibold">{{ $distribusiKelas['Tinggi'] ?? 0 }}</p>
                    </div>
                </div>

            </div> <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold mb-4">Top 5 Gejala Populer</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse($gejalaPopuler as $gejala)
                                <li class="py-3 flex justify-between items-center">
                                    <span>{{ $gejala->input_gejala }}</span>
                                    <span class="font-medium bg-gray-100 px-2 py-1 rounded-full text-sm">{{ $gejala->total }} kali</span>
                                </li>
                            @empty
                                <li class="py-3 text-gray-500">Belum ada data gejala.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold mb-4">5 Servis Terbaru</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse($servisTerbaru as $history)
                                <li class="py-3">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">{{ $history->vehicle->no_polisi }}</span>
                                        <span class="text-sm text-gray-500">{{ $history->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-sm text-gray-600">{{ $history->vehicle->customer->nama_pelanggan }} - ({{ $history->hasil_kelas_prediksi }})</div>
                                </li>
                            @empty
                                <li class="py-3 text-gray-500">Belum ada data servis.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div> </div>
    </div>
</x-app-layout>